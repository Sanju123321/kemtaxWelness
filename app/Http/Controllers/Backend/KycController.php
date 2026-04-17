<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\KycDocument;
use App\Models\User;
use App\Services\ActivityLogger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KycController extends Controller
{
    public function index(Request $request)
    {
        $query = KycDocument::with('user', 'verifiedBy')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('doc_type')) {
            $query->where('doc_type', $request->doc_type);
        }

        $documents = $query->paginate(20);

        $stats = [
            'pending'  => KycDocument::where('status', 'pending')->count(),
            'verified' => KycDocument::where('status', 'verified')->count(),
            'rejected' => KycDocument::where('status', 'rejected')->count(),
        ];

        return view('backend.kyc.index', compact('documents', 'stats'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get(['id', 'name', 'email']);
        return view('backend.kyc.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id'    => 'required|exists:users,id',
            'doc_type'   => 'required|in:aadhaar,pan,selfie,other',
            'doc_number' => 'nullable|string|max:50',
            'status'     => 'required|in:pending,verified,rejected',
            'admin_note' => 'nullable|string|max:500',
        ]);

        $data = $validated;
        if ($validated['status'] === 'verified') {
            $data['verified_by'] = auth('admin')->id();
            $data['verified_at'] = now();
        }

        KycDocument::create($data);

        return redirect()->route('admin.kyc.index')->with('success', 'KYC document added.');
    }

    public function approve(Request $request, string $id)
    {
        $kyc = KycDocument::with('user')->findOrFail($id);

        $kyc->update([
            'status'      => 'verified',
            'admin_note'  => $request->admin_note,
            'verified_by' => auth('admin')->id(),
            'verified_at' => now(),
        ]);

        ActivityLogger::log('kyc_approved', 'KycDocument', $kyc->id, [
            'user'     => $kyc->user->name ?? '',
            'doc_type' => $kyc->doc_type,
        ]);

        return redirect()->back()->with('success', 'KYC document verified.');
    }

    public function reject(Request $request, string $id)
    {
        $request->validate(['admin_note' => 'required|string|max:500']);

        $kyc = KycDocument::with('user')->findOrFail($id);

        $kyc->update([
            'status'      => 'rejected',
            'admin_note'  => $request->admin_note,
            'verified_by' => auth('admin')->id(),
            'verified_at' => now(),
        ]);

        ActivityLogger::log('kyc_rejected', 'KycDocument', $kyc->id, [
            'user'   => $kyc->user->name ?? '',
            'reason' => $request->admin_note,
        ]);

        return redirect()->back()->with('success', 'KYC document rejected.');
    }

    public function destroy(string $id)
    {
        KycDocument::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'KYC record deleted.');
    }
}
