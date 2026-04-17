<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Income;

class IncomeController extends Controller
{
    public function index()
    {
        $incomes = Income::with(['user', 'fromUser'])->latest()->paginate(20);
        $totalCredited = Income::where('status', 'credited')->sum('amount');
        $totalLost     = Income::where('status', 'lost')->sum('amount');
        return view('backend.incomes.index', compact('incomes', 'totalCredited', 'totalLost'));
    }

    public function export()
    {
        $incomes = Income::with(['user', 'fromUser'])->latest()->get();

        $filename = 'incomes_' . now()->format('Ymd_His') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($incomes) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Earner Name', 'Earner Email', 'From Member', 'Level', 'Type', 'Amount (₹)', 'Status', 'Remark', 'Date']);
            foreach ($incomes as $income) {
                fputcsv($handle, [
                    $income->id,
                    $income->user->name ?? 'N/A',
                    $income->user->email ?? '',
                    $income->fromUser->name ?? 'N/A',
                    $income->level,
                    $income->type,
                    $income->amount,
                    $income->status,
                    $income->remark ?? '',
                    $income->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
