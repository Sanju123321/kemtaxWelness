<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\MemberController;
use App\Http\Controllers\Backend\AdminEarningController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\ProductController as BackendProductController;
use App\Http\Controllers\Backend\AdminAuthController;
use App\Http\Controllers\Backend\PlanController;
use App\Http\Controllers\Backend\PaymentController;
use App\Http\Controllers\Backend\IncomeController;
use App\Http\Controllers\Backend\WithdrawalController;
use App\Http\Controllers\Backend\KycController;
use App\Http\Controllers\Backend\TicketController;
use App\Http\Controllers\Backend\AnnouncementController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\ActivityLogController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['maintenance'])->group(function () {

    // Home
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // About
    Route::get('/about', [PageController::class, 'about'])->name('about');

    // Products
    Route::get('/products', [FrontendProductController::class, 'index'])->name('products');
    Route::get('/products/{slug}', [FrontendProductController::class, 'show'])->name('products.show');

    // Cart & Wishlist — require auth (AJAX/API-style JSON responses)
    Route::middleware('auth')->group(function () {
        Route::get('/cart',           [CartController::class, 'index'])->name('cart.index');
        Route::post('/cart/add',      [CartController::class, 'add'])->name('cart.add');
        Route::post('/cart/update',   [CartController::class, 'update'])->name('cart.update');
        Route::post('/cart/remove',   [CartController::class, 'remove'])->name('cart.remove');

        Route::get('/wishlist',           [WishlistController::class, 'index'])->name('wishlist.index');
        Route::post('/wishlist/toggle',   [WishlistController::class, 'toggle'])->name('wishlist.toggle');
        Route::post('/wishlist/remove',   [WishlistController::class, 'remove'])->name('wishlist.remove');
    });
    // Services
    Route::get('/services', [PageController::class, 'services'])->name('services');

    // Blog
    Route::get('/blog', [BlogController::class, 'index'])->name('blog');
    Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

    // Contact
    Route::get('/contact', [PageController::class, 'contact'])->name('contact');
    Route::post('/contact', [PageController::class, 'contactSend'])->name('contact.send');

    // Pricing
    Route::get('/pricing', [PageController::class, 'pricing'])->name('pricing');

    // Portfolio
    Route::get('/portfolio', fn() => view('frontend.portfolio.index'))->name('portfolio');
});

/*
|--------------------------------------------------------------------------
| Frontend Auth Routes (Member Login/Register)
|--------------------------------------------------------------------------
*/
// Guest-only routes (redirect logged-in users to dashboard)
Route::middleware(['maintenance', 'guest'])->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::post('/send-otp', [AuthController::class, 'sendOtp'])->name('send.otp');


    Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp');
    Route::post('/check-phone', [AuthController::class, 'checkPhone'])->name('check.phone');

    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.reset');
    // Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
    Route::post('/reset-password-phone', [AuthController::class, 'resetPassword'])->name('reset.password.phone');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Member Portal Routes — Protected by auth middleware
|--------------------------------------------------------------------------
*/
Route::prefix('member')
    ->name('member.')
    ->middleware(['maintenance', 'auth'])
    ->group(function () {

        Route::get('/dashboard', [MemberController::class, 'dashboard'])->name('dashboard');
        Route::get('/commissions', [MemberController::class, 'commissionsJson'])->name('commissions.json');
        Route::get('/team', [MemberController::class, 'team'])->name('team');
        Route::get('/team/tree', [MemberController::class, 'treeJson'])->name('team.tree');
        Route::get('/setup', [MemberController::class, 'setup'])->name('setup');
        Route::get('/wallet', [MemberController::class, 'wallet'])->name('wallet');
        Route::post('/wallet/withdraw', [MemberController::class, 'submitWithdrawal'])->name('wallet.withdraw');
        Route::get('/profile', [MemberController::class, 'profile'])->name('profile');
        Route::get('/credentials', [MemberController::class, 'credentials'])->name('credentials');
        Route::post('/profile/photo', [MemberController::class, 'updatePhoto'])->name('profile.photo');

        Route::put('/profile/update', [MemberController::class, 'updateProfile'])
            ->name('profile.update');
        Route::post('/change/password', [MemberController::class, 'changePassword'])->name('change.password');
        Route::post('/bank/save', [MemberController::class, 'saveBank'])
            ->name('bank.save');

        // Razorpay payment verification and plan activation
        Route::post('/create-order', [MemberController::class, 'createOrder'])->name('member.create.order');
        Route::post('/wallet/create-order', [MemberController::class, 'createWalletTopupOrder'])->name('wallet.create.order');
        Route::post('/razorpay/webhook', [MemberController::class, 'webhook']);
        Route::post('/verify-payment', [MemberController::class, 'verifyPayment']);
        Route::post('/wallet/verify-payment', [MemberController::class, 'verifyWalletTopupPayment'])->name('wallet.verify.payment');
    });

/*
|--------------------------------------------------------------------------
| Admin Redirect - Redirect /admin to /admin/login
|--------------------------------------------------------------------------
*/
Route::get('/admin', function () {
    if (Auth::check()) {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('admin.login');
});

/*
|--------------------------------------------------------------------------
| Backend / Admin Auth Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    Route::get('/login', [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AdminAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AdminAuthController::class, 'register'])->name('register.post');

    Route::get('/forgot-password', [AdminAuthController::class, 'showForgotPassword'])->name('forgot.password');
    Route::post('/forgot-password', [AdminAuthController::class, 'forgotPassword'])->name('forgot.password.post');
});

/*
|--------------------------------------------------------------------------
| Backend / Admin Routes  — Protected by admin.auth middleware
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['admin.auth'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Change Password (logged-in admin)
        Route::get('/change-password', [AdminAuthController::class, 'showChangePassword'])->name('change.password');
        Route::post('/change-password', [AdminAuthController::class, 'changePassword'])->name('change.password.post');

        // Users
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/export', [UserController::class, 'export'])->name('users.export');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');
        Route::post('/users/{id}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle.status');
        Route::get('/users/{id}/income', [UserController::class, 'income'])->name('users.income');

        // Products
        Route::get('/products', [BackendProductController::class, 'index'])->name('products.index');
        Route::get('/products/export', [BackendProductController::class, 'export'])->name('products.export');
        Route::get('/products/create', [BackendProductController::class, 'create'])->name('products.create');
        Route::post('/products', [BackendProductController::class, 'store'])->name('products.store');
        Route::get('/products/{id}/edit', [BackendProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{id}', [BackendProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}', [BackendProductController::class, 'destroy'])->name('products.destroy');

        // Plans
        Route::get('/plans', [PlanController::class, 'index'])->name('plans.index');
        Route::get('/plans/export', [PlanController::class, 'export'])->name('plans.export');
        Route::get('/plans/create', [PlanController::class, 'create'])->name('plans.create');
        Route::post('/plans', [PlanController::class, 'store'])->name('plans.store');
        Route::get('/plans/{id}/edit', [PlanController::class, 'edit'])->name('plans.edit');
        Route::put('/plans/{id}', [PlanController::class, 'update'])->name('plans.update');
        Route::delete('/plans/{id}', [PlanController::class, 'destroy'])->name('plans.destroy');

        // Payments
        Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
        Route::get('/payments/export', [PaymentController::class, 'export'])->name('payments.export');

        // Incomes / Commissions
        Route::get('/incomes', [IncomeController::class, 'index'])->name('incomes.index');
        Route::get('/incomes/export', [IncomeController::class, 'export'])->name('incomes.export');

        // Admin Earnings (lost income captures + maintenance fees)
        Route::get('/admin-earnings', [AdminEarningController::class, 'index'])->name('admin.earnings.index');
        Route::get('/admin-earnings/export', [AdminEarningController::class, 'export'])->name('admin.earnings.export');

        // Withdrawal Requests
        Route::get('/withdrawals', [WithdrawalController::class, 'index'])->name('withdrawals.index');
        Route::get('/withdrawals/create', [WithdrawalController::class, 'create'])->name('withdrawals.create');
        Route::post('/withdrawals', [WithdrawalController::class, 'store'])->name('withdrawals.store');
        Route::post('/withdrawals/{id}/approve', [WithdrawalController::class, 'approve'])->name('withdrawals.approve');
        Route::post('/withdrawals/{id}/reject', [WithdrawalController::class, 'reject'])->name('withdrawals.reject');
        Route::post('/withdrawals/{id}/sync', [WithdrawalController::class, 'sync'])->name('withdrawals.sync');
        Route::get('/withdrawals/export', [WithdrawalController::class, 'export'])->name('withdrawals.export');

        // KYC Verification
        Route::get('/kyc', [KycController::class, 'index'])->name('kyc.index');
        Route::get('/kyc/create', [KycController::class, 'create'])->name('kyc.create');
        Route::post('/kyc', [KycController::class, 'store'])->name('kyc.store');
        Route::post('/kyc/{id}/approve', [KycController::class, 'approve'])->name('kyc.approve');
        Route::post('/kyc/{id}/reject', [KycController::class, 'reject'])->name('kyc.reject');
        Route::delete('/kyc/{id}', [KycController::class, 'destroy'])->name('kyc.destroy');

        // Support Tickets
        Route::get('/tickets', [TicketController::class, 'index'])->name('tickets.index');
        Route::get('/tickets/create', [TicketController::class, 'create'])->name('tickets.create');
        Route::post('/tickets', [TicketController::class, 'store'])->name('tickets.store');
        Route::get('/tickets/{id}', [TicketController::class, 'show'])->name('tickets.show');
        Route::post('/tickets/{id}/reply', [TicketController::class, 'reply'])->name('tickets.reply');
        Route::post('/tickets/{id}/status', [TicketController::class, 'updateStatus'])->name('tickets.status');
        Route::delete('/tickets/{id}', [TicketController::class, 'destroy'])->name('tickets.destroy');

        // Announcements
        Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
        Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
        Route::put('/announcements/{id}', [AnnouncementController::class, 'update'])->name('announcements.update');
        Route::post('/announcements/{id}/toggle', [AnnouncementController::class, 'toggleActive'])->name('announcements.toggle');
        Route::delete('/announcements/{id}', [AnnouncementController::class, 'destroy'])->name('announcements.destroy');

        // Settings
        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

        // Advanced Reports
        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

        // Activity Log
        Route::get('/activity-log', [ActivityLogController::class, 'index'])->name('activity-log.index');

        // User MLM Tree & Plan History
        Route::get('/users/{id}/tree', [UserController::class, 'tree'])->name('users.tree');
        Route::get('/users/{id}/plan-history', [UserController::class, 'planHistory'])->name('users.plan-history');
        Route::post('/users/{id}/assign-plan', [UserController::class, 'assignPlan'])->name('users.assign-plan');

        // Charts & Tables
        Route::get('/charts', fn() => view('backend.charts.index'))->name('charts');
        Route::get('/tables', fn() => view('backend.tables.index'))->name('tables');

        // Logout
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
    });
