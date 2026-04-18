<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\KycDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MemberKycController extends Controller
{
    public function index()
    {
        $docs = KycDocument::where('user_id', Auth::id())
            ->latest()
            ->get();

        return view('frontend.member.kyc.index', compact('docs'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'doc_type'   => 'required|in:aadhaar,pan,selfie,other',
            'doc_number' => 'nullable|string|max:50',
            'doc_file'   => 'required|file|mimes:jpg,jpeg,png,pdf|max:4096',
        ]);

        $user    = Auth::user();
        $docType = $request->doc_type;

        // Prevent re-submission if already pending or verified for this doc type
        $existing = KycDocument::where('user_id', $user->id)
            ->where('doc_type', $docType)
            ->whereIn('status', ['pending', 'verified'])
            ->first();

        if ($existing) {
            $msg = $existing->status === 'verified'
                ? 'Your ' . strtoupper($docType) . ' document is already verified.'
                : 'Your ' . strtoupper($docType) . ' document is already submitted and pending review.';
            return back()->withErrors(['doc_type' => $msg])->withInput();
        }

        $path = $request->file('doc_file')->store('kyc/' . $user->id, 'public');

        KycDocument::create([
            'user_id'    => $user->id,
            'doc_type'   => $docType,
            'doc_number' => $request->doc_number,
            'file_path'  => $path,
            'status'     => 'pending',
        ]);

        return redirect()->route('member.kyc.index')
            ->with('success', strtoupper($docType) . ' document submitted successfully. Our team will review it within 24–48 hours.');
    }

    public function destroy(string $id)
    {
        $doc = KycDocument::where('id', $id)
            ->where('user_id', Auth::id())
            ->where('status', 'pending')
            ->firstOrFail();

        if ($doc->file_path) {
            Storage::disk('public')->delete($doc->file_path);
        }

        $doc->delete();

        return back()->with('success', 'KYC submission withdrawn successfully.');
    }
}
