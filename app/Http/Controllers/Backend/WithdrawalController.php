<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\WithdrawalRequest;
use App\Services\ActivityLogger;
use App\Services\RazorpayXService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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

    public function approve(Request $request, string $id, RazorpayXService $razorpayXService)
    {
        $request->validate(['admin_remark' => 'nullable|string|max:500']);

        $withdrawal = WithdrawalRequest::with('user.bankDetail')->findOrFail($id);

        if ($withdrawal->status !== 'pending') {
            return redirect()->back()->with('error', 'Request already processed.');
        }

        if ($withdrawal->user->wallet_balance < $withdrawal->amount) {
            return redirect()->back()->with('error', 'User has insufficient wallet balance.');
        }

        if (!$razorpayXService->isConfigured()) {
            return redirect()->back()->with('error', 'RazorpayX payout configuration is incomplete. Set RazorpayX keys and account number.');
        }

        $bankData = $this->resolveBankData($withdrawal);
        if (!$bankData) {
            return redirect()->back()->with('error', 'Bank details are missing for this withdrawal request.');
        }

        try {
            $contactId = $withdrawal->user->bankDetail?->razorpay_contact_id;
            if (!$contactId) {
                $contact = $razorpayXService->createContact($withdrawal->user);
                $contactId = $contact['id'] ?? null;
            }

            if (!$contactId) {
                throw new \RuntimeException('Unable to create RazorpayX contact.');
            }

            $fundAccountId = $withdrawal->user->bankDetail?->razorpay_fund_account_id;
            if (!$fundAccountId) {
                $fundAccount = $razorpayXService->createBankFundAccount($contactId, $bankData);
                $fundAccountId = $fundAccount['id'] ?? null;
            }

            if (!$fundAccountId) {
                throw new \RuntimeException('Unable to create RazorpayX fund account.');
            }

            $idempotencyKey = $withdrawal->idempotency_key ?: (string) Str::uuid();
            $payout = $razorpayXService->createPayout($withdrawal, $fundAccountId, $idempotencyKey);

            DB::transaction(function () use (
                $withdrawal,
                $request,
                $contactId,
                $fundAccountId,
                $payout,
                $idempotencyKey
            ) {
                $payoutStatus = strtolower((string) ($payout['status'] ?? 'pending'));
                $localStatus = $this->mapPayoutStatusToLocalStatus($payoutStatus);

                $withdrawal->update([
                    'status' => $localStatus,
                    'admin_remark' => $request->admin_remark,
                    'processed_by' => auth('admin')->id(),
                    'processed_at' => $localStatus === 'pending' ? null : now(),
                    'razorpay_contact_id' => $contactId,
                    'razorpay_fund_account_id' => $fundAccountId,
                    'razorpay_payout_id' => $payout['id'] ?? null,
                    'payout_status' => $payoutStatus,
                    'payout_reference' => $payout['reference_id'] ?? null,
                    'idempotency_key' => $idempotencyKey,
                    'utr' => $payout['utr'] ?? null,
                    'provider_response' => $payout,
                ]);

                $withdrawal->user->decrement('wallet_balance', $withdrawal->amount);

                if ($withdrawal->user->bankDetail) {
                    $withdrawal->user->bankDetail->update([
                        'razorpay_contact_id' => $contactId,
                        'razorpay_fund_account_id' => $fundAccountId,
                    ]);
                }

                if ($localStatus === 'rejected') {
                    $withdrawal->user->increment('wallet_balance', $withdrawal->amount);
                }
            });
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        ActivityLogger::log('withdrawal_approved', 'WithdrawalRequest', $withdrawal->id, [
            'user'   => $withdrawal->user->name,
            'amount' => $withdrawal->amount,
        ]);

        $withdrawal->refresh();

        return redirect()->back()->with(
            'success',
            "Withdrawal {$withdrawal->id} payout initiated in RazorpayX test mode with status " .
            strtoupper($withdrawal->payout_status ?? $withdrawal->status) . '.'
        );
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
            'processed_by' => auth('admin')->id(),
            'processed_at' => now(),
        ]);

        ActivityLogger::log('withdrawal_rejected', 'WithdrawalRequest', $withdrawal->id, [
            'user'   => $withdrawal->user->name,
            'amount' => $withdrawal->amount,
            'reason' => $request->admin_remark,
        ]);

        return redirect()->back()->with('success', "Withdrawal request rejected.");
    }

    public function sync(string $id, RazorpayXService $razorpayXService)
    {
        $withdrawal = WithdrawalRequest::with('user')->findOrFail($id);

        if (!$withdrawal->razorpay_payout_id) {
            return redirect()->back()->with('error', 'No RazorpayX payout is linked to this withdrawal.');
        }

        try {
            $payout = $razorpayXService->fetchPayout($withdrawal->razorpay_payout_id);
            $this->applyPayoutStatus($withdrawal, $payout, auth('admin')->id());
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        return redirect()->back()->with('success', 'Withdrawal payout status synced from RazorpayX.');
    }

    public function create()
    {
        $users = User::orderBy('name')
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
            fputcsv($handle, ['ID', 'Member', 'Email', 'Amount', 'Method', 'Status', 'Payout Status', 'Payout ID', 'Admin Remark', 'Processed By', 'Processed At', 'Requested At']);
            foreach ($rows as $r) {
                fputcsv($handle, [
                    $r->id,
                    $r->user->name ?? '',
                    $r->user->email ?? '',
                    $r->amount,
                    $r->payment_method,
                    $r->status,
                    $r->payout_status ?? '',
                    $r->razorpay_payout_id ?? '',
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

    private function withdrawalsHavePayoutColumns(): bool
    {
        return !empty(DB::select(
            "select 1 from information_schema.columns where table_schema = database() and table_name = ? and column_name = ? limit 1",
            ['withdrawal_requests', 'razorpay_payout_id']
        ));
    }

    private function resolveBankData(WithdrawalRequest $withdrawal): ?array
    {
        $accountHolder = $withdrawal->account_holder ?: $withdrawal->user->bankDetail?->account_holder;
        $accountNumber = $withdrawal->account_number ?: $withdrawal->user->bankDetail?->account_number;
        $ifsc = $withdrawal->ifsc ?: $withdrawal->user->bankDetail?->ifsc;
        $bankName = $withdrawal->bank_name ?: $withdrawal->user->bankDetail?->bank_name;

        if (!$accountHolder || !$accountNumber || !$ifsc || !$bankName) {
            return null;
        }

        return [
            'account_holder' => $accountHolder,
            'account_number' => $accountNumber,
            'ifsc' => strtoupper($ifsc),
            'bank_name' => $bankName,
        ];
    }

    private function applyPayoutStatus(WithdrawalRequest $withdrawal, array $payout, ?int $adminId = null): void
    {
        DB::transaction(function () use ($withdrawal, $payout, $adminId) {
            $previousStatus = $withdrawal->status;
            $payoutStatus = strtolower((string) ($payout['status'] ?? 'pending'));
            $localStatus = $this->mapPayoutStatusToLocalStatus($payoutStatus);

            $withdrawal->update([
                'status' => $localStatus,
                'processed_by' => $adminId ?? $withdrawal->processed_by,
                'processed_at' => $localStatus === 'pending' ? null : now(),
                'payout_status' => $payoutStatus,
                'payout_reference' => $payout['reference_id'] ?? $withdrawal->payout_reference,
                'utr' => $payout['utr'] ?? $withdrawal->utr,
                'provider_response' => $payout,
            ]);

            if ($previousStatus === 'pending' && $localStatus === 'rejected') {
                $withdrawal->user->increment('wallet_balance', $withdrawal->amount);
            }
        });
    }

    private function mapPayoutStatusToLocalStatus(string $payoutStatus): string
    {
        return match ($payoutStatus) {
            'processed' => 'approved',
            'failed', 'reversed', 'cancelled', 'rejected' => 'rejected',
            default => 'pending',
        };
    }
}
