<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Income;
use App\Models\Payment;
use App\Models\Plan;
use App\Models\User;
use App\Models\UserPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Top 20 earners
        $topEarners = User::where('email', '!=', 'admin@kemtex.com')
            ->where('total_earned', '>', 0)
            ->orderByDesc('total_earned')
            ->limit(20)
            ->get(['id', 'name', 'email', 'total_earned', 'wallet_balance', 'has_plan']);

        // Inactive members (registered but no plan)
        $inactiveMembers = User::where('email', '!=', 'admin@kemtex.com')
            ->where(function ($q) {
                $q->where('has_plan', 0)->orWhereNull('has_plan');
            })
            ->latest()
            ->limit(50)
            ->get(['id', 'name', 'email', 'created_at', 'status']);

        // Revenue by plan
        $revenueByPlan = Plan::withCount(['userPlans as purchase_count'])
            ->withSum('userPlans as total_revenue', 'amount_paid')
            ->get(['id', 'name', 'price']);

        // Monthly commissions (last 12 months)
        $monthlyCommissions = Income::where('status', 'credited')
            ->where('created_at', '>=', now()->subMonths(12))
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, SUM(amount) as total, COUNT(*) as count")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Level distribution
        $levelDistribution = Income::where('status', 'credited')
            ->selectRaw('level, COUNT(*) as count, SUM(amount) as total')
            ->groupBy('level')
            ->orderBy('level')
            ->get();

        // Member growth (last 12 months)
        $memberGrowth = User::where('email', '!=', 'admin@kemtex.com')
            ->where('created_at', '>=', now()->subMonths(12))
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as month, COUNT(*) as count")
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('backend.reports.index', compact(
            'topEarners', 'inactiveMembers', 'revenueByPlan',
            'monthlyCommissions', 'levelDistribution', 'memberGrowth'
        ));
    }
}
