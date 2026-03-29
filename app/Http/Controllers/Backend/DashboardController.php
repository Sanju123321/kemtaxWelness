<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index()
    {
        // In a real app, pass real stats from your models:
        // $stats = [
        //     'total_users'    => User::count(),
        //     'total_orders'   => Order::count(),
        //     'total_revenue'  => Order::sum('amount'),
        //     'total_products' => Product::count(),
        // ];

        return view('backend.dashboard.index');
    }
}
