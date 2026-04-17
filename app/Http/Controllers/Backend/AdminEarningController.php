<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AdminEarning;

class AdminEarningController extends Controller
{
    public function index()
    {
        $earnings = AdminEarning::with(['fromUser', 'beneficiaryUser'])
            ->latest()
            ->paginate(25);

        $totalLostCapture   = AdminEarning::where('type', 'lost_capture')->sum('amount');
        $totalMaintenanceFee = AdminEarning::where('type', 'maintenance_fee')->sum('amount');
        $grandTotal         = $totalLostCapture + $totalMaintenanceFee;

        return view('backend.admin-earnings.index', compact(
            'earnings',
            'totalLostCapture',
            'totalMaintenanceFee',
            'grandTotal'
        ));
    }

    public function export()
    {
        $earnings = AdminEarning::with(['fromUser', 'beneficiaryUser'])->latest()->get();

        $filename = 'admin_earnings_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($earnings) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Type', 'Amount (₹)', 'From Member', 'Beneficiary User', 'Remark', 'Date']);
            foreach ($earnings as $e) {
                fputcsv($handle, [
                    $e->id,
                    $e->type === 'maintenance_fee' ? 'Maintenance Fee (10%)' : 'Lost Income Capture',
                    $e->amount,
                    $e->fromUser->name ?? 'N/A',
                    $e->beneficiaryUser->name ?? 'N/A',
                    $e->remark ?? '',
                    $e->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
