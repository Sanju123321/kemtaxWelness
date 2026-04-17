<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Models\TicketReply;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    public function index(Request $request)
    {
        $query = Ticket::with('user')->withCount('replies')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        $tickets = $query->paginate(20);

        $stats = [
            'open'        => Ticket::where('status', 'open')->count(),
            'in_progress' => Ticket::where('status', 'in_progress')->count(),
            'resolved'    => Ticket::where('status', 'resolved')->count(),
            'closed'      => Ticket::where('status', 'closed')->count(),
        ];

        return view('backend.tickets.index', compact('tickets', 'stats'));
    }

    public function create()
    {
        $users = \App\Models\User::orderBy('name')->get(['id', 'name', 'email']);
        return view('backend.tickets.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'  => 'required|exists:users,id',
            'subject'  => 'required|string|max:255',
            'message'  => 'required|string',
            'category' => 'required|in:billing,technical,mlm,account,other',
            'priority' => 'required|in:low,medium,high,urgent',
        ]);

        $validated['ticket_number'] = 'TKT-' . strtoupper(Str::random(8));

        Ticket::create($validated);

        return redirect()->route('admin.tickets.index')->with('success', 'Ticket created.');
    }

    public function show(string $id)
    {
        $ticket  = Ticket::with(['user', 'replies.user', 'replies.admin'])->findOrFail($id);
        $replies = $ticket->replies()->with(['user', 'admin'])->orderBy('created_at')->get();

        return view('backend.tickets.show', compact('ticket', 'replies'));
    }

    public function reply(Request $request, string $id)
    {
        $request->validate(['message' => 'required|string']);

        $ticket = Ticket::findOrFail($id);

        TicketReply::create([
            'ticket_id' => $ticket->id,
            'admin_id'  => auth('admin')->id(),
            'message'   => $request->message,
            'is_admin'  => true,
        ]);

        if ($ticket->status === 'open') {
            $ticket->update(['status' => 'in_progress']);
        }

        return redirect()->back()->with('success', 'Reply sent.');
    }

    public function updateStatus(Request $request, string $id)
    {
        $request->validate(['status' => 'required|in:open,in_progress,resolved,closed']);

        $ticket = Ticket::findOrFail($id);
        $ticket->update(['status' => $request->status]);

        ActivityLogger::log('ticket_status_changed', 'Ticket', $ticket->id, [
            'new_status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Ticket status updated.');
    }

    public function destroy(string $id)
    {
        Ticket::findOrFail($id)->delete();
        return redirect()->route('admin.tickets.index')->with('success', 'Ticket deleted.');
    }
}
