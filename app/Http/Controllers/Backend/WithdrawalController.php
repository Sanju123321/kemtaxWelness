<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WithdrawalRequest;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class WithdrawalController extends Controller
{
    public function index(Request $request)
    {
        $query = WithdrawalRequest::with('user', 'processedBy')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $withdrawals = $query->paginate(20);

        $stats = [
            'pending'        => WithdrawalRequest::where('status', 'pending')->count(),
            'approved'       => WithdrawalRequest::where('status', 'approved')->count(),
            'rejected'       => WithdrawalRequest::where('status', 'rejected')->count(),
            'total_approved' => WithdrawalRequest::where('status', 'approved')->sum('amount'),
            'total_pending'  => WithdrawalRequest::where('status', 'pending')->sum('amount'),
        ];

        return view('backend.withdrawals.index', compact('withdrawals', 'stats'));
    }

    public function approve(Request $request, string $id)
    {
        $request->validate(['admin_remark' => 'nullable|string|max:500']);

        $withdrawal = WithdrawalRequest::with('user')->findOrFail($id);

        if ($withdrawal->status !== 'pending') {
            return redirect()->back()->with('error', 'Request already processed.');
        }

        if ($withdrawal->user->wallet_balance < $withdrawal->amount) {
            return redirect()->back()->with('error', 'User has insufficient wallet balance.');
        }

        DB::transaction(function () use ($withdrawal, $request) {
            $withdrawal->update([
                'status'       => 'approved',
                'admin_remark' => $request->admin_remark,
                'processed_by' => Auth::id(),
                'processed_at' => now(),
            ]);

            $withdrawal->user->decrement('wallet_balance', $withdrawal->amount);
        });

        ActivityLogger::log('withdrawal_approved', 'WithdrawalRequest', $withdrawal->id, [
            'user'   => $withdrawal->user->name,
            'amount' => $withdrawal->amount,
        ]);

        return redirect()->back()->with('success', "Withdrawal of ₹{$withdrawal->amount} approved for {$withdrawal->user->name}.");
    }

    public function reject(Request $request, string $id)
    {
        $request->validate(['admin_remark' => 'required|string|max:500']);

        $withdrawal = WithdrawalRequest::with('user')->findOrFail($id);

        if ($withdrawal->status !== 'pending') {
            return redirect()->back()->with('error', 'Request already processed.');
        }

        $withdrawal->update([
            'status'       => 'rejected',
            'admin_remark' => $request->admin_remark,
            'processed_by' => Auth::id(),
            'processed_at' => now(),
        ]);

        ActivityLogger::log('withdrawal_rejected', 'WithdrawalRequest', $withdrawal->id, [
            'user'   => $withdrawal->user->name,
            'amount' => $withdrawal->amount,
            'reason' => $request->admin_remark,
        ]);

        return redirect()->back()->with('success', "Withdrawal request rejected.");
    }

    public function create()
    {
        $users = User::where('email', '!=', 'admin@kemtex.com')
            ->orderBy('name')
            ->get(['id', 'name', 'email', 'wallet_balance']);

        return view('backend.withdrawals.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'        => 'required|exists:users,id',
            'amount'         => 'required|numeric|min:1',
            'payment_method' => 'required|in:bank,upi',
            'account_holder' => 'nullable|string|max:100',
            'account_number' => 'nullable|string|max:50',
            'ifsc'           => 'nullable|string|max:20',
            'bank_name'      => 'nullable|string|max:100',
            'upi_id'         => 'nullable|string|max:100',
        ]);

        WithdrawalRequest::create($validated);

        return redirect()->route('admin.withdrawals.index')->with('success', 'Withdrawal request created.');
    }

    public function export()
    {
        $rows = WithdrawalRequest::with('user', 'processedBy')->latest()->get();

        $filename = 'withdrawals_' . now()->format('Ymd_His') . '.csv';
        $headers  = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($rows) {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Member', 'Email', 'Amount', 'Method', 'Status', 'Admin Remark', 'Processed By', 'Processed At', 'Requested At']);
            foreach ($rows as $r) {
                fputcsv($handle, [
                    $r->id,
                    $r->user->name ?? '',
                    $r->user->email ?? '',
                    $r->amount,
                    $r->payment_method,
                    $r->status,
                    $r->admin_remark ?? '',
                    $r->processedBy->name ?? '',
                    $r->processed_at?->format('Y-m-d H:i:s') ?? '',
                    $r->created_at->format('Y-m-d H:i:s'),
                ]);
            }
            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
