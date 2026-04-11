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
use App\Jobs\DistributeIncomeJob;
use Illuminate\Support\Facades\DB;
class MemberController extends Controller{
    /**
     * Verify Razorpay payment and activate plan for user
     */



    public function createOrder(Request $request)
{
    $request->validate([
        'amount' => 'required|numeric|min:1'
    ]);

    // 🔒 FIXED PLAN AMOUNT (always verify)
   

    $api = new \Razorpay\Api\Api(env('RAZORPAY_KEY_ID'), env('RAZORPAY_KEY_SECRET'));

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

            // 🔴 RULE 2: Only Upgrade
            if ($user->current_plan_id) {
                $currentPlan = $user->currentPlan;

                if ($plan->price <= $currentPlan->price) {
                    throw new \Exception("Only upgrade allowed. Please select a higher plan.");
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
                'contact' => $paymentData->contact
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

            //  MLM TRIGGER
            dispatch(new DistributeIncomeJob($user->id));

        });

        return response()->json(['success' => true]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ]);
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

        $dashStats = [
            'total_earnings'   => $user->total_earned ?? 0,
            'direct_referrals' => $directReferrals,
            'team_size'        => $teamSize,
            'wallet_balance'   => $user->wallet_balance ?? 0,
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
            'dashStats',
            'wishlistItems',
            'cartItems',
            'cartTotal',
            'planAmount',
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
        $user = auth()->user();

        $paginator = Income::with('fromUser')
            ->where('user_id', $user->id)
            ->latest()
            ->paginate(5);

        $items = $paginator->getCollection()->map(function ($income) {
            return [
                'date'      => $income->created_at->format('M d, Y'),
                'from'      => $income->fromUser->name ?? 'N/A',
                'type'      => $income->type === 'direct' ? 'Direct Ref.' : 'Level ' . $income->level,
                'amount'    => number_format($income->amount, 2),
                'status'    => ucfirst($income->status),
            ];
        });

        return response()->json([
            'data'         => $items,
            'current_page' => $paginator->currentPage(),
            'last_page'    => $paginator->lastPage(),
            'total'        => $paginator->total(),
            'per_page'     => $paginator->perPage(),
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
            ->select('id', 'name', 'status', 'current_plan_id', 'total_earned', 'wallet_balance', 'reference_code')
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
            'status'       => $user->status ?? 'inactive',
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

    /**
     * Show wallet page.
     */
    public function wallet()
    {
        $user = auth()->user();

        $walletBalance = $user->wallet_balance ?? 0;
        $totalEarned   = $user->total_earned   ?? 0;

        $plan     = $user->currentPlan;
        $dailyCap = $plan?->daily_cap  ?? 0;
        $totalCap = $plan?->total_cap  ?? 0;

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

        // Recent wallet transactions (credited incomes)
        $recentTransactions = Income::with('fromUser')
            ->where('user_id', $user->id)
            ->where('status', 'credited')
            ->latest()
            ->take(10)
            ->get();

        return view('frontend.member.wallet.index', compact(
            'walletBalance',
            'totalEarned',
            'dailyCap',
            'totalCap',
            'todayEarned',
            'todayLost',
            'plan',
            'recentTransactions',
        ));
    }

    /**
     * Show profile page.
     */
    public function profile()
    {
        return view('frontend.member.profile.index');
    }

    /**
     * Show credentials page.
     */
    public function credentials()
    {
        return view('frontend.member.credentials.index');
    }
}

