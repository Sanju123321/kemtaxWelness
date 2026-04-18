<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactMessage::latest();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('message', 'like', "%{$s}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_read', $request->status === 'read' ? 1 : 0);
        }

        $messages = $query->paginate(20)->withQueryString();
        $unreadCount = ContactMessage::where('is_read', false)->count();

        return view('backend.contact.index', compact('messages', 'unreadCount'));
    }

    public function show(string $id)
    {
        $msg = ContactMessage::findOrFail($id);

        // Mark as read when opened
        if (!$msg->is_read) {
            $msg->update(['is_read' => true]);
        }

        return view('backend.contact.show', compact('msg'));
    }

    public function markRead(string $id)
    {
        ContactMessage::findOrFail($id)->update(['is_read' => true]);
        return redirect()->back()->with('success', 'Marked as read.');
    }

    public function destroy(string $id)
    {
        ContactMessage::findOrFail($id)->delete();
        return redirect()->route('admin.contact.index')->with('success', 'Message deleted.');
    }
}
