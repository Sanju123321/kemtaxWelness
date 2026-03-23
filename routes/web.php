<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/
Route::prefix('/')->name('')->group(function () {

    // Home
    Route::get('/', fn() => view('frontend.home.index'))->name('home');

    // About
    Route::get('/about', fn() => view('frontend.about.index'))->name('about');

    // Products
    Route::get('/products', fn() => view('frontend.products.index'))->name('products');

    // Services
    Route::get('/services', fn() => view('frontend.services.index'))->name('services');

    // Blog
    Route::get('/blog', fn() => view('frontend.blog.index'))->name('blog');

    // Contact
    Route::get('/contact', fn() => view('frontend.contact.index'))->name('contact');
    Route::post('/contact', fn() => back()->with('success', 'Your message has been sent! We will get back to you shortly.'))->name('contact.send');

});

/*
|--------------------------------------------------------------------------
| Backend / Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/', fn() => view('backend.dashboard.index'))->name('dashboard');
    Route::get('/dashboard', fn() => view('backend.dashboard.index'))->name('dashboard.alt');

    // Users (resource stubs)
    Route::get('/users', fn() => view('backend.dashboard.index'))->name('users.index');
    Route::get('/users/create', fn() => view('backend.dashboard.index'))->name('users.create');
    Route::get('/users/{id}/edit', fn() => view('backend.dashboard.index'))->name('users.edit');

    // Products (resource stubs)
    Route::get('/products', fn() => view('backend.dashboard.index'))->name('products.index');
    Route::get('/products/create', fn() => view('backend.dashboard.index'))->name('products.create');
    Route::get('/products/{id}/edit', fn() => view('backend.dashboard.index'))->name('products.edit');

    // Logout (stub — replace with Auth::logout() logic when auth is set up)
    Route::get('/logout', fn() => redirect()->route('home'))->name('logout');
    Route::post('/logout', fn() => redirect()->route('home'))->name('logout.post');

});

/*
|--------------------------------------------------------------------------
| Auth Routes (stubs — replace with Laravel Breeze / Jetstream as needed)
|--------------------------------------------------------------------------
*/
Route::get('/login', fn() => redirect()->route('admin.dashboard'))->name('login');
Route::get('/register', fn() => redirect()->route('home'))->name('register');
