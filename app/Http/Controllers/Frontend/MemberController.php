<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\Http\Request;
 use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Plan;
use App\Models\UserPlan;
use App\Models\Income;
use App\Models\UserTree;
use App\Models\Setting;
use App\Models\WithdrawalRequest;
use App\Models\RepurchaseWalletTopup;
use App\Services\RazorpayXService;
use App\Jobs\DistributeIncomeJob;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use App\Models\UserBankDetail;
use Illuminate\Database\Eloquent\Builder;

class MemberController extends Controller
{
    /**
     * Verify Razorpay payment and activate plan for user
     */



public function createOrder(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric|min:1'
    ]);

    // 🔒 FIXED PLAN AMOUNT (always verify)
   

    // $api = new \Razorpay\Api\Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));
    $api = new \Razorpay\Api\Api(
        config('services.razorpay.key'),
        config('services.razorpay.secret')
    );

    $order = $api->order->create([
        'receipt' => 'order_' . time(),
        'amount' => $request->amount * 100,
        'currency' => 'INR'
    ]);

    return response()->json([
        'order_id' => $order['id'],
        'amount' => $request->amount * 100
    ]);
}

public function createWalletTopupOrder(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric|min:100'
    ]);

    $user = auth()->user();

    $api = new Api(
        config('services.razorpay.key'),
        config('services.razorpay.secret')
    );

    $amount = round((float) $request->amount, 2);
    $order = $api->order->create([
        'receipt' => 'wallet_topup_' . $user->id . '_' . time(),
        'amount' => (int) round($amount * 100),
        'currency' => 'INR',
        'notes' => [
            'purpose' => 'wallet_topup',
            'user_id' => (string) $user->id,
        ],
    ]);

    return response()->json([
        'order_id' => $order['id'],
        'amount' => (int) round($amount * 100),
        'display_amount' => $amount,
        'name' => $user->name,
        'email' => $user->email,
        'contact' => $user->phone,
    ]);
}

    public function createRepurchaseWalletTopupOrder(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100'
        ]);

        $user = auth()->user();

        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        $amount = round((float) $request->amount, 2);
        $order = $api->order->create([
            'receipt' => 'repurchase_wallet_topup_' . $user->id . '_' . time(),
            'amount' => (int) round($amount * 100),
            'currency' => 'INR',
            'notes' => [
                'purpose' => 'repurchase_wallet_topup',
                'user_id' => (string) $user->id,
            ],
        ]);

        return response()->json([
            'order_id' => $order['id'],
            'amount' => (int) round($amount * 100),
            'display_amount' => $amount,
            'name' => $user->name,
            'email' => $user->email,
            'contact' => $user->phone,
        ]);
    }

// public function verifyPayment(Request $request)
// {
//     $api = new Api(
//         config('services.razorpay.key'),
//         config('services.razorpay.secret')
//     );

//     try {
//         $attributes = [
//             'razorpay_order_id' => $request->razorpay_order_id,
//             'razorpay_payment_id' => $request->razorpay_payment_id,
//             'razorpay_signature' => $request->razorpay_signature
//         ];

//         // ✅ Verify signature
//         $api->utility->verifyPaymentSignature($attributes);

//         // ✅ FETCH PAYMENT DATA (MISSING STEP 🔥)
//         $paymentData = $api->payment->fetch($request->razorpay_payment_id);

//         $user = auth()->user();

//         // ✅ Prevent duplicate entry
//         if (Payment::where('payment_id', $paymentData->id)->exists()) {
//             return response()->json(['success' => true]);
//         }

//         // ✅ Save payment
//         Payment::create([
//             'user_id' => $user->id,
//             'payment_id' => $paymentData->id,
//             'order_id' => $paymentData->order_id,
//             'amount' => $paymentData->amount / 100, // paise → rupees
//             'status' => $paymentData->status,
//             'method' => $paymentData->method,
//             'email' => $paymentData->email,
//             'contact' => $paymentData->contact
//         ]);

//         // ✅ Activate user
       
//        $user->status = 'active';
//         $user->has_plan = true;
//         $user->save();

//         return response()->json(['success' => true]);

//     } catch (SignatureVerificationError $e) {
//         return response()->json(['success' => false]);
//     }
// }
public function verifyPayment(Request $request)
{
    $api = new Api(
        config('services.razorpay.key'),
        config('services.razorpay.secret')
    );

    try {
        DB::transaction(function () use ($request, $api) {

            // ✅ Verify signature
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ]);

            // ✅ Fetch payment
            $paymentData = $api->payment->fetch($request->razorpay_payment_id);

            $user = auth()->user();

            // ✅ Prevent duplicate
            if (Payment::where('payment_id', $paymentData->id)->exists()) {
                return;
            }

            $amount = $paymentData->amount / 100;

            // ✅ Get Plan
            $plan = Plan::where('price', $amount)->first();

            if (!$plan) {
                throw new \Exception("Invalid Plan");
            }

            // 🔴 RULE 1: New users must start with the cheapest active plan
            if (!$user->current_plan_id) {
                $starterPlan = Plan::where('is_active', 1)->orderBy('price')->first();
                if (!$starterPlan || $plan->id !== $starterPlan->id) {
                    throw new \Exception("New members must start with the Starter Package (₹" . ($starterPlan->price ?? '') . ")");
                }
            }

            // 🔴 RULE 2: Only sequential upgrades
            if ($user->current_plan_id) {
                $currentPlan = $user->currentPlan;

                if ($plan->price <= $currentPlan->price) {
                    throw new \Exception("Only plan upgrades are allowed. Please choose a higher plan.");
                }

                $nextPlan = Plan::where('is_active', 1)
                    ->where('price', '>', $currentPlan->price)
                    ->orderBy('price')
                    ->first();

                    
                if (!$nextPlan) {
                    throw new \Exception("You already have the highest available plan.");
                }

                if ($plan->id !== $nextPlan->id) {
                    throw new \Exception("Please upgrade step-by-step. Your next eligible plan is " . $nextPlan->name . " (₹" . $nextPlan->price . ").");
                }
            }

            // ✅ Save Payment
            Payment::create([
                'user_id' => $user->id,
                'payment_id' => $paymentData->id,
                'order_id' => $paymentData->order_id,
                'amount' => $amount,
                'status' => $paymentData->status,
                'method' => $paymentData->method,
                'email' => $paymentData->email,
                'contact' => $paymentData->contact,
                'purpose' => 'plan',
            ]);

            // ✅ Update user (ACTIVE PLAN)
            $oldPlanId = $user->current_plan_id;

            // $user->update([
            //     'status' => 'active',
            //     'current_plan_id' => $plan->id
            // ]);
            $user->current_plan_id = $plan->id;
             $user->status = 'active';
             $user->has_plan = true;
                $user->save();
            // ✅ Update old plan → upgraded
            if ($oldPlanId) {
                UserPlan::where('user_id', $user->id)
                    ->where('plan_id', $oldPlanId)
                    ->update(['status' => 'upgraded']);
            }

            // ✅ Save new plan
            UserPlan::create([
                'user_id' => $user->id,
                'plan_id' => $plan->id,
                'amount_paid' => $plan->price,
                'status' => 'active',
                'activated_at' => now()
            ]);

            //  MLM TRIGGER — upgrade vs first plan purchase
            dispatch(new DistributeIncomeJob(
                $user->id,
                $oldPlanId ? 'plan_upgrade' : 'referral'
            ));

        });

        return response()->json(['success' => true]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ]);
    }
}

public function verifyWalletTopupPayment(Request $request)
{
    $request->validate([
        'razorpay_order_id' => 'required|string',
        'razorpay_payment_id' => 'required|string',
        'razorpay_signature' => 'required|string',
    ]);

    $api = new Api(
        config('services.razorpay.key'),
        config('services.razorpay.secret')
    );

    try {
        DB::transaction(function () use ($request, $api) {
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id' => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature' => $request->razorpay_signature
            ]);

            $paymentData = $api->payment->fetch($request->razorpay_payment_id);
            $user = auth()->user();

            if (Payment::where('payment_id', $paymentData->id)->exists()) {
                return;
            }

            $amount = round($paymentData->amount / 100, 2);

            Payment::create([
                'user_id' => $user->id,
                'payment_id' => $paymentData->id,
                'order_id' => $paymentData->order_id,
                'amount' => $amount,
                'status' => $paymentData->status,
                'method' => $paymentData->method,
                'email' => $paymentData->email,
                'contact' => $paymentData->contact,
                'purpose' => 'wallet_topup',
            ]);

            if ($paymentData->status === 'captured') {
                $user->increment('wallet_balance', $amount);
            } else {
                throw new \Exception('Wallet top-up payment is not captured.');
            }
        });

        return response()->json(['success' => true]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage(),
        ], 422);
    }
}

    public function verifyRepurchaseWalletTopupPayment(Request $request)
    {
        $request->validate([
            'razorpay_order_id' => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_signature' => 'required|string',
        ]);

        $api = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        try {
            DB::transaction(function () use ($request, $api) {
                $api->utility->verifyPaymentSignature([
                    'razorpay_order_id' => $request->razorpay_order_id,
                    'razorpay_payment_id' => $request->razorpay_payment_id,
                    'razorpay_signature' => $request->razorpay_signature
                ]);

                $paymentData = $api->payment->fetch($request->razorpay_payment_id);
                $user = auth()->user();

                if (Payment::where('payment_id', $paymentData->id)->exists()) {
                    return;
                }

                $amount = round($paymentData->amount / 100, 2);

                Payment::create([
                    'user_id' => $user->id,
                    'payment_id' => $paymentData->id,
                    'order_id' => $paymentData->order_id,
                    'amount' => $amount,
                    'status' => $paymentData->status,
                    'method' => $paymentData->method,
                    'email' => $paymentData->email,
                    'contact' => $paymentData->contact,
                    'purpose' => 'repurchase_wallet_topup',
                ]);

                if ($paymentData->status === 'captured') {
                    RepurchaseWalletTopup::create([
                        'user_id' => $user->id,
                        'amount' => $amount,
                        'bank_reference' => 'razorpay',
                        'proof' => null,
                        'status' => 'approved',
                    ]);
                } else {
                    throw new \Exception('Repurchase wallet top-up payment is not captured.');
                }
            });

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 422);
        }
    }

// public function webhook(Request $request)
// {
//     $webhookSecret = env('RAZORPAY_WEBHOOK_SECRET');

//     $signature = $request->header('X-Razorpay-Signature');
//     $payload = $request->getContent();

//     try {
//         $api = new \Razorpay\Api\Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));

//         $api->utility->verifyWebhookSignature($payload, $signature, $webhookSecret);

//         $data = json_decode($payload, true);

//         if ($data['event'] == 'payment.captured') {
//             $payment = $data['payload']['payment']['entity'];

//             // Save in DB
//             \DB::table('payments')->insert([
//                 'payment_id' => $payment['id'],
//                 'amount' => $payment['amount'] / 100,
//                 'status' => $payment['status'],
//                 'created_at' => now()
//             ]);
//         }

//         return response()->json(['status' => 'ok']);

//     } catch (\Exception $e) {
//         return response()->json(['error' => 'Invalid signature'], 400);
//     }
// }
    /**
     * Show member dashboard.
     */
    public function dashboard()
    {
        $user = auth()->user();

        // Real dashboard stats
        $directReferrals = UserTree::where('upline_id', $user->id)->where('level', 1)->count();
        $teamSize        = UserTree::where('upline_id', $user->id)->count();

        // Cap calculations
        $plan      = $user->currentPlan;
        $dailyCap  = $plan?->daily_cap  ?? 0;
        $totalCap  = $plan?->total_cap  ?? 0;

        $todayEarned = \App\Models\Income::where('user_id', $user->id)
            ->where('status', 'credited')
            ->whereDate('created_at', today())
            ->sum('amount');

        $totalEarned = $user->total_earned ?? 0;

        // Lost income = all income records with status 'lost'
        $lostIncome = \App\Models\Income::where('user_id', $user->id)
            ->where('status', 'lost')
            ->sum('amount');

        // Locked earning = amount earned beyond daily or total cap (same as lost income)
        $lockedEarning = $lostIncome;

        // Daily cap hit?
        $dailyCapHit  = $dailyCap > 0 && $todayEarned >= $dailyCap;
        // Total cap hit?
        $totalCapHit  = $totalCap > 0 && $totalEarned >= $totalCap;
        $capHit       = $dailyCapHit || $totalCapHit;

        // Next (upgrade) plan
        $nextPlan = $plan
            ? \App\Models\Plan::where('price', '>', $plan->price)
                ->where('is_active', true)
                ->orderBy('price')
                ->first()
            : null;

        $dashStats = [
            'total_earnings'   => $totalEarned,
            'direct_referrals' => $directReferrals,
            'team_size'        => $teamSize,
            'wallet_balance'   => $user->wallet_balance ?? 0,
            'lost_income'      => $lostIncome,
        ];

        // Wishlist items with eager-loaded products
        $wishlistItems = Wishlist::with('product')
            ->where('user_id', $user->id)
            ->latest()
            ->get();

        // Cart items with eager-loaded products
        $cartItems = Cart::with('product')
            ->where('user_id', $user->id)
            ->get();

        $cartTotal = $cartItems->sum(fn($i) => $i->quantity * ($i->product->price ?? 0));

        // Starter plan amount for the purchase modal (cheapest active plan)
        $starterPlan = Plan::where('is_active', 1)->orderBy('price')->first();
        $planAmount  = $starterPlan?->price ?? 1500;

        return view('frontend.member.dashboard.index', compact(
            'user',
            'dashStats',
            'wishlistItems',
            'cartItems',
            'cartTotal',
            'planAmount',
            'plan',
            'nextPlan',
            'dailyCap',
            'totalCap',
            'todayEarned',
            'totalEarned',
            'lostIncome',
            'lockedEarning',
            'capHit',
            'user',
            'dailyCapHit',
            'totalCapHit',
            'starterPlan'
        ));
    }

    /**
     * Show setup page (for new users with reference code).
     */
    public function setup()
    {
        return view('frontend.member.setup.index');
    }

    /**
     * Return paginated commissions as JSON for AJAX requests.
     */
    public function commissionsJson(Request $request)
    {
        $paginator = $this->buildCommissionQuery(auth()->id())
            ->latest()
            ->paginate(10);

        $items = $paginator->getCollection()->map(fn ($income) => $this->formatCommissionRow($income));

        return response()->json([
            'data'         => $items,
            'current_page' => $paginator->currentPage(),
            'last_page'    => $paginator->lastPage(),
            'total'        => $paginator->total(),
            'per_page'     => $paginator->perPage(),
        ]);
    }

    public function commissionsHistory(Request $request)
    {
        $query = $this->buildCommissionQuery(auth()->id());

        $search = trim((string) $request->query('search', ''));
        if ($search !== '') {
            $query->where(function (Builder $inner) use ($search) {
                $inner->whereHas('fromUser', fn (Builder $q) => $q->where('name', 'like', '%' . $search . '%'))
                    ->orWhere('type', 'like', '%' . $search . '%')
                    ->orWhere('status', 'like', '%' . $search . '%')
                    ->orWhere('level', 'like', '%' . $search . '%');
            });
        }

        $sortBy = $request->query('sort_by', 'date');
        $sortDir = strtolower((string) $request->query('sort_dir', 'desc')) === 'asc' ? 'asc' : 'desc';

        if ($sortBy === 'amount') {
            $query->orderBy('amount', $sortDir);
        } elseif ($sortBy === 'type') {
            $query->orderBy('type', $sortDir);
        } elseif ($sortBy === 'level') {
            $query->orderBy('level', $sortDir);
        } elseif ($sortBy === 'status') {
            $query->orderBy('status', $sortDir);
        } elseif ($sortBy === 'from') {
            $query->leftJoin('users as from_users', 'incomes.from_user_id', '=', 'from_users.id')
                ->select('incomes.*')
                ->orderBy('from_users.name', $sortDir);
        } else {
            $query->orderBy('created_at', $sortDir);
        }

        $rows = $query->paginate(20)->appends($request->query());

        return view('frontend.member.commissions.index', [
            'rows' => $rows,
            'search' => $search,
            'sortBy' => $sortBy,
            'sortDir' => $sortDir,
        ]);
    }

    /**
     * Show the My Team genealogy page.
     */
    public function team()
    {
        return view('frontend.member.mytree.index');
    }

    /**
     * Return team genealogy tree as JSON for AJAX rendering.
     */
    public function treeJson()
    {
        $tree = $this->buildMemberTree(auth()->id(), 0);
        return response()->json($tree);
    }

    private function buildMemberTree(int $userId, int $depth): array
    {
        $user = User::with('currentPlan')
            ->select('id', 'name', 'status', 'profile_photo', 'current_plan_id', 'total_earned', 'wallet_balance', 'reference_code')
            ->find($userId);
        if (!$user) return [];

        $children = UserTree::where('upline_id', $userId)
            ->where('level', 1)
            ->pluck('user_id')
            ->map(fn($id) => $this->buildMemberTree($id, $depth + 1))
            ->filter()
            ->values()
            ->toArray();

        return [
            'id'           => $user->id,
            'name'         => $user->name,
            'depth'        => $depth,
            'profile_photo' => $user->profile_photo,
            'status'       => $user->status ?? 'inactive',
            'has_plan'     => !empty($user->current_plan_id),
            'direct_referrals' => UserTree::where('upline_id', $user->id)->where('level', 1)->count(),
            'ref_code'     => $user->reference_code ?? '-',
            'plan_name'    => $user->currentPlan?->name ?? 'No Plan',
            'plan_price'   => $user->currentPlan?->price ?? 0,
            'plan_code'    => $user->currentPlan?->code ?? '-',
            'daily_cap'    => $user->currentPlan?->daily_cap ?? 0,
            'total_cap'    => $user->currentPlan?->total_cap ?? 0,
            'total_earned' => $user->total_earned ?? 0,
            'wallet'       => $user->wallet_balance ?? 0,
               'children'     => $children,
        ];
    }

public function saveBank(Request $request)
{
    $request->validate([
        'account_holder' => 'required|string|max:255',
        'account_number' => 'required',
        'ifsc' => 'required',
        'bank_name' => 'required',
        'upi_id' => 'nullable',
    ]);

    $user = auth()->user();

    UserBankDetail::updateOrCreate(
        ['user_id' => $user->id], // check existing
        [
            'account_holder' => $request->account_holder,
            'account_number' => $request->account_number,
            'ifsc' => $request->ifsc,
            'bank_name' => $request->bank_name,
            'upi_id' => $request->upi_id,
        ]
    );

    return back()->with('success', 'Bank details saved successfully');
}
    /**
     * Show wallet page.
     */
    public function wallet()
    {
        $user = auth()->user();

        $walletBalance = $user->wallet_balance ?? 0;
        $totalEarned   = $user->total_earned   ?? 0;
        $repurchaseWallet = RepurchaseWalletTopup::where('user_id', $user->id)
            ->where('status', 'approved')
            ->sum('amount');

        $plan = $user->currentPlan;
        $dailyCap = $plan?->daily_cap  ?? 0;
        $totalCap = $plan?->total_cap  ?? 0;
        $minWithdrawal = (float) Setting::getValue('min_withdrawal_amount', 500);

        // Today earnings (credited)
        $todayEarned = Income::where('user_id', $user->id)
            ->where('status', 'credited')
            ->whereDate('created_at', today())
            ->sum('amount');

        // Today lost (due to daily cap)
        $todayLost = Income::where('user_id', $user->id)
            ->where('status', 'lost')
            ->whereDate('created_at', today())
            ->sum('amount');

        $creditedTransactionsCount = Income::where('user_id', $user->id)
            ->where('status', 'credited')
            ->count();

        $pendingWithdrawalAmount = WithdrawalRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->sum('amount');
        $openWithdrawalRequestAmount = WithdrawalRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->when(
                $this->withdrawalsHavePayoutColumns(),
                fn ($query) => $query->whereNull('razorpay_payout_id')
            )
            ->sum('amount');

        $availableWithdrawalBalance = max(0, $walletBalance - $openWithdrawalRequestAmount);

        $approvedWithdrawalAmount = WithdrawalRequest::where('user_id', $user->id)
            ->where('status', 'approved')
            ->sum('amount');

        $lastTransactionAt = Income::where('user_id', $user->id)->latest()->value('created_at')
            ?? WithdrawalRequest::where('user_id', $user->id)->latest()->value('created_at')
            ?? now();

        $recentIncomeTransactions = Income::with('fromUser')
            ->where('user_id', $user->id)
            ->where('status', 'credited')
            ->latest()
            ->take(10)
            ->get();

        $recentWithdrawalTransactions = WithdrawalRequest::where('user_id', $user->id)
            ->latest()
            ->take(10)
            ->get();

        $recentTopups = Payment::where('user_id', $user->id)
            ->where('purpose', 'wallet_topup')
            ->where('status', 'captured')
            ->latest()
            ->take(10)
            ->get();
        $recentRepurchaseTopups = RepurchaseWalletTopup::where('user_id', $user->id)
            ->where('status', 'approved')
            ->latest()
            ->take(10)
            ->get();
        $recentPlanUpgrades = Payment::where('user_id', $user->id)
            ->where('purpose', 'plan')
            ->where('status', 'captured')
            ->latest()
            ->take(10)
            ->get();

        $recentTransactions = $recentIncomeTransactions
            ->map(function ($income) {
                return [
                    'kind'        => 'credit',
                    'icon'        => $income->type === 'direct' ? 'fa-user-plus' : 'fa-layer-group',
                    'title'       => $income->type === 'direct'
                        ? 'Direct Referral'
                        : 'Level ' . $income->level . ' Commission',
                    'subtitle'    => 'From: ' . ($income->fromUser?->name ?? 'N/A'),
                    'date'        => $income->created_at,
                    'amount'      => (float) $income->amount,
                    'status'      => 'credited',
                    'status_text' => 'Credited',
                ];
            })
            ->merge(
                $recentWithdrawalTransactions->map(function ($withdrawal) {
                    return [
                        'kind'        => 'debit',
                        'icon'        => 'fa-arrow-up',
                        'title'       => 'Withdrawal Request',
                        'subtitle'    => 'Method: ' . strtoupper($withdrawal->payment_method ?? 'bank'),
                        'date'        => $withdrawal->created_at,
                        'amount'      => (float) $withdrawal->amount,
                        'status'      => $withdrawal->status,
                        'status_text' => ucfirst($withdrawal->status),
                    ];
                })
            )
            ->merge(
                $recentTopups->map(function ($payment) {
                    return [
                        'kind'        => 'credit',
                        'icon'        => 'fa-plus-circle',
                        'title'       => 'Wallet Top Up',
                        'subtitle'    => 'Via ' . ucfirst($payment->method ?? 'Razorpay'),
                        'date'        => $payment->created_at,
                        'amount'      => (float) $payment->amount,
                        'status'      => 'credited',
                        'status_text' => 'Added',
                    ];
                })
            )
            ->merge(
                $recentRepurchaseTopups->map(function ($entry) {
                    $isMainWalletTransfer = $entry->bank_reference === 'main_wallet_transfer';

                    return [
                        'kind'        => $isMainWalletTransfer ? 'debit' : 'credit',
                        'icon'        => $isMainWalletTransfer ? 'fa-random' : 'fa-coins',
                        'title'       => $isMainWalletTransfer ? 'Transfer to Repurchase Wallet' : 'Repurchase Wallet Top Up',
                        'subtitle'    => $isMainWalletTransfer
                            ? 'Moved from main wallet'
                            : 'Added via ' . ucfirst((string) ($entry->bank_reference ?: 'Razorpay')),
                        'date'        => $entry->created_at,
                        'amount'      => (float) $entry->amount,
                        'status'      => 'approved',
                        'status_text' => $isMainWalletTransfer ? 'Transferred' : 'Added',
                    ];
                })
            )
            ->merge(
                $recentPlanUpgrades->map(function ($payment) {
                    return [
                        'kind'        => 'debit',
                        'icon'        => 'fa-arrow-circle-up',
                        'title'       => 'Plan Upgraded',
                        'subtitle'    => 'Upgrade payment via ' . ucfirst($payment->method ?? 'Razorpay'),
                        'date'        => $payment->created_at,
                        'amount'      => (float) $payment->amount,
                        'status'      => 'approved',
                        'status_text' => 'Upgraded',
                    ];
                })
            )
            ->sortByDesc('date')
            ->take(30)
            ->values();

        return view('frontend.member.wallet.index', compact(
            'walletBalance',
            'repurchaseWallet',
            'totalEarned',
            'dailyCap',
            'totalCap',
            'todayEarned',
            'todayLost',
            'plan',
            'minWithdrawal',
            'creditedTransactionsCount',
            'pendingWithdrawalAmount',
            'availableWithdrawalBalance',
            'approvedWithdrawalAmount',
            'lastTransactionAt',
            'recentTransactions',
        ));
    }

    public function transferToRepurchaseWallet(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100',
        ]);

        $user = auth()->user();
        $amount = round($request->amount, 2);

        if ($amount > ($user->wallet_balance ?? 0)) {
            return back()->with('error', 'Insufficient main wallet balance to transfer.');
        }

        DB::transaction(function () use ($user, $amount) {
            $user->decrement('wallet_balance', $amount);

            RepurchaseWalletTopup::create([
                'user_id' => $user->id,
                'amount' => $amount,
                'bank_reference' => 'main_wallet_transfer',
                'proof' => null,
                'status' => 'approved',
            ]);
        });

        return back()->with('success', 'Amount transferred from main wallet to repurchase wallet.');
    }

    public function repurchaseTopup(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100',
            'bank_reference' => 'required|string|max:255',
            'proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:4096',
        ]);

        $user = auth()->user();
        $proofPath = $request->file('proof')->store('repurchase_proofs', 'public');

        RepurchaseWalletTopup::create([
            'user_id' => $user->id,
            'amount' => round($request->amount, 2),
            'bank_reference' => $request->bank_reference,
            'proof' => $proofPath,
            'status' => 'approved',
        ]);

        return redirect()->route('member.wallet')->with('success', 'Your repurchase wallet has been topped up successfully.');
    }

    public function submitWithdrawal(Request $request, RazorpayXService $razorpayXService)
    {
        $user = auth()->user();
        $minWithdrawal = (float) Setting::getValue('min_withdrawal_amount', 500);
        $pendingWithdrawalAmount = WithdrawalRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->sum('amount');
        $openWithdrawalRequestAmount = WithdrawalRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->when(
                $this->withdrawalsHavePayoutColumns(),
                fn ($query) => $query->whereNull('razorpay_payout_id')
            )
            ->sum('amount');
        $availableWithdrawalBalance = max(0, (float) $user->wallet_balance - $openWithdrawalRequestAmount);

        $request->validate([
            'amount' => ['required', 'numeric', 'min:' . $minWithdrawal],
        ]);

        if ($user->status === 'inactive') {
            return back()->with('error', 'Inactive members cannot request withdrawals.');
        }

        if (!$user->bankDetail) {
            return back()->with('error', 'Please save your bank details before requesting a withdrawal.');
        }

        if (!$razorpayXService->isConfigured()) {
            return back()->with('error', 'RazorpayX payout configuration is incomplete. Add your RazorpayX account number first.');
        }

        if ((float) $request->amount > $availableWithdrawalBalance) {
            return back()->with('error', 'Withdrawal amount exceeds your available main wallet balance.');
        }

        WithdrawalRequest::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'status' => 'pending',
            'payment_method' => 'bank',
            'account_holder' => $user->bankDetail->account_holder,
            'account_number' => $user->bankDetail->account_number,
            'ifsc' => $user->bankDetail->ifsc,
            'bank_name' => $user->bankDetail->bank_name,
            'upi_id' => $user->bankDetail->upi_id,
        ]);

        return back()->with('success', 'Withdrawal request submitted. Admin approval will trigger the RazorpayX test payout.');
    }

    /**
     * Show profile page.
     */
    public function profile()
    {
        return view('frontend.member.profile.index');
    }

public function updateProfile(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'phone' => 'nullable|digits:10',
        'city' => 'nullable|string|max:100',
        'state' => 'nullable|string|max:100',
        'pincode' => 'nullable|digits:6',
        'address' => 'nullable|string|max:2000',
    ]);

    $user = auth()->user();

    
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->city = $request->city;
        $user->state = $request->state;
        $user->pincode = $request->pincode;
        $user->address = $request->address;
        $user->save();

    return back()->with('success', 'Profile updated successfully');
}


public function changePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'password' => 'required|min:6|confirmed',
    ]);

    $user = auth()->user();

    // Check current password
    if (!Hash::check($request->current_password, $user->password)) {
        return back()->with('error', 'Current password is incorrect');
    }

    // Update password
    $user->password = Hash::make($request->password);
    $user->save();

    return back()->with('success', 'Password updated successfully');
}
public function updatePhoto(Request $request)
{
    $request->validate([
        'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $user = auth()->user();

    // Delete old image
    if ($user->profile_photo && Storage::disk('public')->exists($user->profile_photo)) {
        Storage::disk('public')->delete($user->profile_photo);
    }

    // Upload new image
    $path = $request->file('photo')->store('profile_photos', 'public');


    $user->profile_photo = $path;
    $user->save();
return back()->with('success', 'Profile photo updated');
}
    /**
     * Show credentials page.
     */
    public function credentials()
    {
        return view('frontend.member.credentials.index');
    }

    private function withdrawalsHavePayoutColumns(): bool
    {
        return !empty(DB::select(
            "select 1 from information_schema.columns where table_schema = database() and table_name = ? and column_name = ? limit 1",
            ['withdrawal_requests', 'razorpay_payout_id']
        ));
    }

    private function buildCommissionQuery(int $userId): Builder
    {
        return Income::with('fromUser')
            ->where('user_id', $userId);
    }

    private function commissionDisplayType(Income $income): string
    {
        return ($income->commission_source ?? 'referral') === 'plan_upgrade'
            ? 'Upgraded Plan'
            : 'Referral';
    }

    private function commissionLevelLabel($level): string
    {
        if ((int) $level <= 1) {
            return 'Direct (Level 1)';
        }

        return 'Level ' . (int) $level;
    }

    private function formatCommissionRow(Income $income): array
    {
        return [
            'date' => $income->created_at->format('M d, Y'),
            'from' => $income->fromUser->name ?? 'N/A',
            'type' => $this->commissionDisplayType($income),
            'level' => $this->commissionLevelLabel($income->level),
            'amount' => number_format((float) $income->amount, 2),
            'status' => ucfirst((string) $income->status),
        ];
    }
}
