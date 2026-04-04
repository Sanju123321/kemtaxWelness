<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\ProductController as FrontendProductController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\WishlistController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\MemberController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\ProductController as BackendProductController;
use App\Http\Controllers\Backend\AdminAuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/
Route::group([], function () {

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
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');

    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::post('/send-otp', [AuthController::class, 'sendOtp'])->name('send.otp');

   
   Route::post('/verify-otp', [AuthController::class, 'verifyOtp'])->name('verify.otp');
   Route::post('/check-phone', [AuthController::class, 'checkPhone'])->name('check.phone');

    Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'forgotPassword'])->name('password.email');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| Member Portal Routes — Protected by auth middleware
|--------------------------------------------------------------------------
*/
Route::prefix('member')
    ->name('member.')
    ->middleware(['auth'])
    ->group(function () {

        Route::get('/dashboard', [MemberController::class, 'dashboard'])->name('dashboard');
        Route::get('/setup', [MemberController::class, 'setup'])->name('setup');
        Route::get('/wallet', [MemberController::class, 'wallet'])->name('wallet');
        Route::get('/profile', [MemberController::class, 'profile'])->name('profile');
        Route::get('/credentials', [MemberController::class, 'credentials'])->name('credentials');

        // Razorpay payment verification and plan activation
       Route::post('/create-order', [MemberController::class, 'createOrder']);
       Route::post('/razorpay/webhook', [MemberController::class, 'webhook']);
        Route::post('/verify-payment', [MemberController::class, 'verifyPayment']);
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

        // Users
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        // Products
        Route::get('/products', [BackendProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [BackendProductController::class, 'create'])->name('products.create');
        Route::post('/products', [BackendProductController::class, 'store'])->name('products.store');
        Route::get('/products/{id}/edit', [BackendProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{id}', [BackendProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}', [BackendProductController::class, 'destroy'])->name('products.destroy');

        // Charts & Tables
        Route::get('/charts', fn() => view('backend.charts.index'))->name('charts');
        Route::get('/tables', fn() => view('backend.tables.index'))->name('tables');

        // Logout
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

    });
