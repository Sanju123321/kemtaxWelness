<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    /**
     * Show member dashboard.
     */
    public function dashboard()
    {
        $user = auth()->user();

        // Get user stats (placeholder - replace with actual queries)
        $stats = [
            'total_earnings'   => 0,
            'direct_referrals' => 0,
            'team_size'        => 0,
            'wallet_balance'   => 0,
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

        return view('frontend.member.dashboard.index', compact(
            'stats',
            'wishlistItems',
            'cartItems',
            'cartTotal',
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
     * Show wallet page.
     */
    public function wallet()
    {
        return view('frontend.member.wallet.index');
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
