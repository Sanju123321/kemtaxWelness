<?php

namespace App\Http\Middleware;

use App\Models\KycDocument;
use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckKycVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        // Only enforce for authenticated members
        if (!Auth::check()) {
            return $next($request);
        }

        // If admin has disabled KYC requirement, let through
        if (Setting::getValue('kyc_required', '0') != '1') {
            return $next($request);
        }

        // Allow access to the KYC pages themselves so the member can submit
        if ($request->routeIs('member.kyc.*')) {
            return $next($request);
        }

        // Check if the member has at least one verified KYC document
        $hasVerified = KycDocument::where('user_id', Auth::id())
            ->where('status', 'verified')
            ->exists();

        if (!$hasVerified) {
            return redirect()->route('member.kyc.index')
                ->with('warning', 'KYC verification is required to access the member portal. Please submit your documents.');
        }

        return $next($request);
    }
}
