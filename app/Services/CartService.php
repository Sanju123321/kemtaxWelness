<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use App\Repositories\Contracts\CartRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class CartService
{
    public function __construct(
        private readonly CartRepositoryInterface $cartRepo
    ) {}

    public function getCart(int $userId): array
    {
        $items = $this->cartRepo->getForUser($userId);

        return [
            'items'       => $items,
            'count'       => $items->sum('quantity'),
            'total'       => $items->sum(fn($i) => $i->quantity * ($i->product->price ?? 0)),
            'item_count'  => $items->count(),
        ];
    }

    public function addItem(int $userId, int $productId, int $qty = 1): array
    {
        // Validate product exists and is active
        $product = Product::active()->find($productId);

        if (!$product) {
            return ['success' => false, 'message' => 'Product not found or unavailable.'];
        }

        if ($product->stock < 1) {
            return ['success' => false, 'message' => 'Product is out of stock.'];
        }

        $currentQty = Cart::where('user_id', $userId)
            ->where('product_id', $productId)
            ->value('quantity') ?? 0;

        if (($currentQty + $qty) > $product->stock) {
            return [
                'success' => false,
                'message' => "Only {$product->stock} unit(s) available in stock.",
                'quantity' => (int) $currentQty,
                'cart_count' => $this->cartRepo->count($userId),
                'cart_total' => $this->cartRepo->itemTotal($userId),
            ];
        }

        $cart = $this->cartRepo->addOrIncrement($userId, $productId, $qty);

        return [
            'success'    => true,
            'message'    => "'{$product->name}' added to your cart.",
            'quantity'   => $cart->quantity,
            'line_total' => round($cart->quantity * $product->price, 2),
            'cart_count' => $this->cartRepo->count($userId),
            'cart_total' => $this->cartRepo->itemTotal($userId),
        ];
    }

    public function removeItem(int $userId, int $productId): array
    {
        $removed = $this->cartRepo->remove($userId, $productId);

        return [
            'success'    => $removed,
            'message'    => $removed ? 'Item removed from cart.' : 'Item not found in cart.',
            'cart_count' => $this->cartRepo->count($userId),
            'cart_total' => $this->cartRepo->itemTotal($userId),
        ];
    }

    public function updateItem(int $userId, int $productId, int $qty): array
    {
        $product = Product::active()->find($productId);

        if (!$product) {
            return ['success' => false, 'message' => 'Product not found.'];
        }

        if ($qty < 1) {
            return ['success' => false, 'message' => 'Quantity must be at least 1.'];
        }

        if ($qty > $product->stock) {
            $currentQty = Cart::where('user_id', $userId)
                ->where('product_id', $productId)
                ->value('quantity') ?? 1;

            return [
                'success' => false,
                'message' => "Only {$product->stock} unit(s) available in stock.",
                'quantity' => (int) $currentQty,
                'cart_count' => $this->cartRepo->count($userId),
                'cart_total' => $this->cartRepo->itemTotal($userId),
            ];
        }

        $cart = $this->cartRepo->update($userId, $productId, $qty);

        return [
            'success'     => true,
            'message'     => 'Quantity updated.',
            'quantity'    => $cart->quantity,
            'line_total'  => round($cart->quantity * $product->price, 2),
            'cart_count'  => $this->cartRepo->count($userId),
            'cart_total'  => $this->cartRepo->itemTotal($userId),
        ];
    }

    public function cartCount(int $userId): int
    {
        return $this->cartRepo->count($userId);
    }
}
