<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Income;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $year = date('Y');

        // Member Growth: signups per month this year
        $growthRaw = User::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', $year)
            ->where('email', '!=', 'admin@kemtex.com')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $memberGrowthData = array_map(fn($m) => $growthRaw[$m] ?? 0, range(1, 12));

        // Revenue Distribution: captured payments per month this year
        $revenueRaw = Payment::selectRaw('MONTH(created_at) as month, SUM(amount) as total')
            ->whereYear('created_at', $year)
            ->where('status', 'captured')
            ->groupBy('month')
            ->pluck('total', 'month')
            ->toArray();

        $monthlyRevenueData = array_map(fn($m) => round($revenueRaw[$m] ?? 0, 2), range(1, 12));

        return view('backend.dashboard.index', compact('memberGrowthData', 'monthlyRevenueData'));
    }
}
