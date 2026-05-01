<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\Plan;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Use Bootstrap 5 pagination views (not Tailwind)
        Paginator::useBootstrapFive();

        // Share $cartCount globally with all views so the header badge works on every page.
        View::composer('*', function ($view) {
            $cartCount = 0;
            if (auth()->check()) {
                $cartCount = Cart::where('user_id', auth()->id())->sum('quantity');
            }
            $view->with('cartCount', $cartCount);

            // Cheapest active plan (starter / Bronze) for modals and payment amount
            $plan = Plan::where('is_active', true)->orderBy('price')->first();

            $view->with([
                'cartCount' => $cartCount,
                'plan' => $plan,
            ]);
        });
    }
}
