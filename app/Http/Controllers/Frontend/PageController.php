<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Show the About Us page.
     */
    public function about()
    {
        return view('frontend.about.index');
    }

    /**
     * Show the Services page.
     */
    public function services()
    {
        return view('frontend.services.index');
    }

    /**
     * Show the Contact page.
     */
    public function contact()
    {
        return view('frontend.contact.index');
    }

    /**
     * Show the Pricing page.
     */
    public function pricing()
    {

        return view('frontend.pricing.index');
    }

    /**
     * Handle the Contact form submission.
     */
    public function contactSend(Request $request)
    {
        $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'min:10'],
        ]);

        // TODO: Send email via Mail::to(...) or store in DB

        return back()->with('success', 'Your message has been sent! We will get back to you shortly.');
    }
}
