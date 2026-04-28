<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutSectionController extends Controller
{
    public function index()
    {
        $settings = Setting::whereIn('key', [
            'about_intro_heading',
            'about_intro_body',
            'about_intro_image',
            'about_top_earners',
            'about_success_stories',
        ])->pluck('value', 'key');

        $topEarners = json_decode($settings->get('about_top_earners', '[]'), true) ?: [];
        $stories = json_decode($settings->get('about_success_stories', '[]'), true) ?: [];

        return view('backend.about.index', [
            'about' => [
                'intro_heading' => $settings->get('about_intro_heading', 'What we are'),
                'intro_body' => $settings->get('about_intro_body', ''),
                'intro_image' => $settings->get('about_intro_image', ''),
                'top_earners' => $topEarners,
                'stories' => $stories,
            ],
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'intro_heading' => ['nullable', 'string', 'max:255'],
            'intro_body' => ['nullable', 'string'],
            'intro_image' => ['nullable', 'image', 'max:4096'],
            'top_earners' => ['nullable', 'array'],
            'top_earners.*.name' => ['nullable', 'string', 'max:255'],
            'top_earners.*.title' => ['nullable', 'string', 'max:255'],
            'top_earners.*.image' => ['nullable', 'image', 'max:4096'],
            'stories' => ['nullable', 'array'],
            'stories.*.name' => ['nullable', 'string', 'max:255'],
            'stories.*.title' => ['nullable', 'string', 'max:255'],
            'stories.*.quote' => ['nullable', 'string', 'max:2000'],
        ]);

        if ($request->hasFile('intro_image')) {
            $introPath = $request->file('intro_image')->store('about', 'public');
            Setting::updateOrCreate(
                ['key' => 'about_intro_image'],
                ['value' => $introPath, 'group' => 'about', 'label' => 'About Intro Image', 'type' => 'text']
            );
        }

        Setting::updateOrCreate(
            ['key' => 'about_intro_heading'],
            ['value' => $validated['intro_heading'] ?? 'What we are', 'group' => 'about', 'label' => 'About Intro Heading', 'type' => 'text']
        );

        Setting::updateOrCreate(
            ['key' => 'about_intro_body'],
            ['value' => $validated['intro_body'] ?? '', 'group' => 'about', 'label' => 'About Intro Body', 'type' => 'textarea']
        );

        $existingTopEarners = json_decode(Setting::getValue('about_top_earners', '[]'), true) ?: [];
        $topEarnersInput = $validated['top_earners'] ?? [];
        $topEarners = [];

        foreach ($topEarnersInput as $index => $earner) {
            $name = trim($earner['name'] ?? '');
            $title = trim($earner['title'] ?? '');
            if ($name === '' && $title === '' && !$request->hasFile("top_earners.$index.image")) {
                continue;
            }

            $image = $existingTopEarners[$index]['image'] ?? null;
            if ($request->hasFile("top_earners.$index.image")) {
                if ($image && Storage::disk('public')->exists($image)) {
                    Storage::disk('public')->delete($image);
                }
                $image = $request->file("top_earners.$index.image")->store('about/top-earners', 'public');
            }

            $topEarners[] = [
                'name' => $name,
                'title' => $title,
                'image' => $image,
            ];
        }

        Setting::updateOrCreate(
            ['key' => 'about_top_earners'],
            ['value' => json_encode($topEarners), 'group' => 'about', 'label' => 'About Top Earners', 'type' => 'textarea']
        );

        $storiesInput = $validated['stories'] ?? [];
        $stories = [];
        foreach ($storiesInput as $story) {
            $name = trim($story['name'] ?? '');
            $title = trim($story['title'] ?? '');
            $quote = trim($story['quote'] ?? '');
            if ($name === '' && $title === '' && $quote === '') {
                continue;
            }
            $stories[] = compact('name', 'title', 'quote');
        }

        Setting::updateOrCreate(
            ['key' => 'about_success_stories'],
            ['value' => json_encode($stories), 'group' => 'about', 'label' => 'About Success Stories', 'type' => 'textarea']
        );

        return back()->with('success', 'About Us content updated successfully.');
    }
}
