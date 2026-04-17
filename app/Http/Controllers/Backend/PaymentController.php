<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('user')->latest()->paginate(20);
        $totalRevenue = Payment::where('status', 'captured')->sum('amount');

        return view('backend.payments.index', compact('payments', 'totalRevenue'));
    }

    public function export()
    {
        $payments = Payment::with('user')->latest()->get();

        $filename = 'payments_' . now()->format('Ymd_His') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($payments) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Member Name', 'Email', 'Payment ID', 'Order ID', 'Purpose', 'Amount (Rs)', 'Method', 'Status', 'Date']);

            foreach ($payments as $payment) {
                fputcsv($handle, [
                    $payment->id,
                    $payment->user->name ?? 'N/A',
                    $payment->email ?? ($payment->user->email ?? ''),
                    $payment->payment_id,
                    $payment->order_id,
                    $payment->purpose ?? 'plan',
                    $payment->amount,
                    $payment->method ?? '',
                    $payment->status,
                    $payment->created_at->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
