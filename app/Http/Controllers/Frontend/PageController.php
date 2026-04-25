<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\ContactMessage;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

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
        $packages = Plan::where('is_active', true)->get();
        return view('frontend.pricing.index', compact('packages'));
    }

    /**
     * Handle the Contact form submission.
     */
    public function contactSend(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email'],
            'phone'    => ['nullable', 'string', 'max:20'],
            'interest' => ['nullable', 'string', 'max:255'],
            'message'  => ['required', 'string', 'min:10'],
        ]);

        // Save to database for admin inbox
        ContactMessage::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'phone'    => $validated['phone'] ?? null,
            'interest' => $validated['interest'] ?? null,
            'message'  => $validated['message'],
        ]);

        Mail::to('support@kemtexwellness.com')
            ->send(new ContactMail(
                senderName: $validated['name'],
                senderEmail: $validated['email'],
                phone: $validated['phone'] ?? null,
                interest: $validated['interest'] ?? null,
                userMessage: $validated['message'],
            ));

        return back()->with('success', 'Your message has been sent! We will get back to you shortly.');
    }
}
