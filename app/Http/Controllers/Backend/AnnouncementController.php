<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $announcements = Announcement::latest()->paginate(20);
        return view('backend.announcements.index', compact('announcements'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'body'       => 'required|string',
            'type'       => 'required|in:info,warning,success,danger',
            'target'     => 'required|in:all,active,inactive,with_plan,without_plan',
            'is_active'  => 'boolean',
            'expires_at' => 'nullable|date|after:now',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        Announcement::create($validated);

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement published.');
    }

    public function update(Request $request, string $id)
    {
        $announcement = Announcement::findOrFail($id);

        $validated = $request->validate([
            'title'      => 'required|string|max:255',
            'body'       => 'required|string',
            'type'       => 'required|in:info,warning,success,danger',
            'target'     => 'required|in:all,active,inactive,with_plan,without_plan',
            'is_active'  => 'boolean',
            'expires_at' => 'nullable|date',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        $announcement->update($validated);

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement updated.');
    }

    public function toggleActive(string $id)
    {
        $announcement = Announcement::findOrFail($id);
        $announcement->update(['is_active' => !$announcement->is_active]);

        return redirect()->back()->with('success', 'Announcement status toggled.');
    }

    public function destroy(string $id)
    {
        Announcement::findOrFail($id)->delete();
        return redirect()->route('admin.announcements.index')->with('success', 'Announcement deleted.');
    }
}
