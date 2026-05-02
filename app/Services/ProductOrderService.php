<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\ProductOrder;
use App\Models\RepurchaseWalletTopup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductOrderService
{
    public function checkout(int $userId): array
    {
        return DB::transaction(function () use ($userId) {
            $cartItems = Cart::with('product')
                ->where('user_id', $userId)
                ->lockForUpdate()
                ->get()
                ->filter(fn (Cart $item) => $item->product);

            if ($cartItems->isEmpty()) {
                return ['success' => false, 'message' => 'Your cart is empty.'];
            }

            foreach ($cartItems as $item) {
                if ($item->product->status !== 'active') {
                    return ['success' => false, 'message' => "'{$item->product->name}' is no longer available."];
                }

                if ($item->quantity > $item->product->stock) {
                    return ['success' => false, 'message' => "Only {$item->product->stock} unit(s) available for {$item->product->name}."];
                }
            }

            $total = round($cartItems->sum(fn (Cart $item) => $item->quantity * (float) $item->product->price), 2);
            $repurchaseBalance = $this->repurchaseWalletBalance($userId);

            if ($total > $repurchaseBalance) {
                return [
                    'success' => false,
                    'message' => 'Insufficient repurchase wallet balance for this purchase.',
                    'cart_total' => $total,
                    'wallet_balance' => $repurchaseBalance,
                ];
            }

            $order = ProductOrder::create([
                'order_number' => $this->nextOrderNumber(),
                'user_id' => $userId,
                'subtotal' => $total,
                'total' => $total,
                'payment_method' => 'repurchase_wallet',
                'payment_status' => 'paid',
                'status' => 'placed',
            ]);

            foreach ($cartItems as $item) {
                $product = $item->product;
                $lineTotal = round($item->quantity * (float) $product->price, 2);

                $order->items()->create([
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'sku' => $product->sku,
                    'price' => $product->price,
                    'quantity' => $item->quantity,
                    'line_total' => $lineTotal,
                ]);

                $product->decrement('stock', $item->quantity);
            }

            RepurchaseWalletTopup::create([
                'user_id' => $userId,
                'amount' => -$total,
                'bank_reference' => 'product_order_' . $order->order_number,
                'proof' => null,
                'status' => 'approved',
            ]);

            Cart::where('user_id', $userId)->delete();

            return [
                'success' => true,
                'message' => "Order {$order->order_number} placed successfully.",
                'order_id' => $order->id,
                'order_number' => $order->order_number,
                'cart_count' => 0,
                'cart_total' => 0,
                'wallet_balance' => $this->repurchaseWalletBalance($userId),
            ];
        });
    }

    public function repurchaseWalletBalance(int $userId): float
    {
        return round((float) RepurchaseWalletTopup::where('user_id', $userId)
            ->where('status', 'approved')
            ->sum('amount'), 2);
    }

    private function nextOrderNumber(): string
    {
        do {
            $number = 'KW' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
        } while (ProductOrder::where('order_number', $number)->exists());

        return $number;
    }
}
