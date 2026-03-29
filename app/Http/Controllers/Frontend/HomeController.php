<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display the homepage.
     */
    public function index()
    {
        // Example: pass dynamic data to the view
        // $featuredProducts = Product::where('featured', true)->take(4)->get();
        // $testimonials = Testimonial::latest()->take(6)->get();

        return view('frontend.home.index');
    }
}
