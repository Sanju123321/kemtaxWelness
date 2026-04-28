<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\ContactMail;
use App\Models\ContactMessage;
use App\Models\Plan;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PageController extends Controller
{
    /**
     * Show the About Us page.
     */
    public function about()
    {
        $introHeading = Setting::getValue('about_intro_heading', 'What we are');
        $introBody = Setting::getValue('about_intro_body', 'KemtexWellness is a wellness-driven multi-level marketing company dedicated to empowering individuals through entrepreneurship and healthier living.');
        $introImage = Setting::getValue('about_intro_image', 'frontend/images/about/home-7.jpg');

        $topEarners = json_decode(Setting::getValue('about_top_earners', '[]'), true) ?: [];
        $stories = json_decode(Setting::getValue('about_success_stories', '[]'), true) ?: [];

        return view('frontend.about.index', compact('introHeading', 'introBody', 'introImage', 'topEarners', 'stories'));
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
