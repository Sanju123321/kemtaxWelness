<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;
use App\Models\PhoneVerification;
use Illuminate\Support\Str;
use App\Models\UserTree;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    /**
     * Show the login form.
     */
    public function showLogin()
    {
        return view('frontend.auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'user_id' => 'required',
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('member.dashboard'));
        }

        return back()->withErrors([
            'user_id' => 'The provided credentials do not match our records.',
        ])->onlyInput('user_id');
    }

    /**
     * Show the registration form.
     */
    public function showRegister()
    {
        return view('frontend.auth.register');
    }

    /**
     * Handle registration request.
     */
    public function register(Request $request, SmsService $sms)
    {
        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'email'          => ['required', 'email', 'unique:users,email'],
            'phone'          => ['required', 'digits:10', 'unique:users,phone'],
            'reference_code' => ['nullable', 'string', 'max:50'],
            'password'       => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $verification = PhoneVerification::where('phone', $validated['phone'])
            ->where('is_verified', 1)
            ->first();

        if (!$verification) {
            return back()->withErrors([
                'phone' => 'Please verify OTP before registration'
            ]);
        }
        // Check if reference code exists (if provided)
        // ✅ Generate UNIQUE USER ID
        do {
            $userId = 'KM' . strtoupper(Str::random(6));
        } while (User::where('user_id', $userId)->exists());

        // ✅ Generate UNIQUE REFERRAL CODE
        do {
            $referralCode = 'REF' . strtoupper(Str::random(6));
        } while (User::where('reference_code', $referralCode)->exists());

        $referredBy = null;
        if (!empty($validated['reference_code'])) {
            $referrer = User::where('reference_code', $validated['reference_code'])
                ->first();

            if ($referrer) {
                $referredBy = $referrer->id;
            }
        }

        $user = User::create([
            'name'          => $validated['name'],
            'email'         => $validated['email'],
            'phone'         => $validated['phone'] ?? null,
            'reference_code' => $referralCode,
            'user_id'       => $userId,
            'referred_by'   => $referredBy,
            'password'      => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        $this->buildTree($user);
        // Redirect based on reference code
        if (!empty($validated['reference_code'])) {
            return redirect()->route('member.dashboard')
                ->with('success', 'Welcome! Please complete your plan payment to activate your account.');
        }
        $message = "Welcome to Kemtex Wellness!\n" .
            "User ID: " . $userId . "\n" .
            "Use your password to login.Thank you for joining us!";

        if ($user->phone) {
            $sms->sendSMS($user->phone, $message);
        }
        return redirect()->route('member.dashboard')
            ->with('success', 'Welcome to Kemtex Wellness! Your account has been created successfully.');
    }

    public function buildTree($user)
    {
        $sponsor = User::find($user->referred_by);

        $level = 1;

        while ($sponsor && $level <= 20) {

            UserTree::create([
                'user_id' => $user->id,
                'upline_id' => $sponsor->id,
                'level' => $level,
            ]);

            $sponsor = User::find($sponsor->referred_by);
            $level++;
        }
    }
    // Check if phone number is already registered
    public function checkPhone(Request $request)
    {
        $validated = $request->validate([
            'phone' => ['required', 'digits:10'],
        ]);

        $exists = User::where('phone', $validated['phone'])->exists();

        return response()->json([
            'exists' => $exists,
        ]);
    }
    /**
     * Show forgot password form.
     */
    public function showForgotPassword()
    {
        return view('frontend.auth.forgot-password');
    }

    /**
     * Handle forgot password request.
     */
    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => ['required', 'email']]);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Handle logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'You have been logged out successfully.');
    }

    /**
     * Send OTP to phone number.
     */
    public function sendOtp(Request $request, SmsService $sms)
    {
        $request->validate([
            'phone' => ['required', 'regex:/^(91\d{10}|\d{10})$/'],
        ]);

        try {
            $otp = (string) random_int(1000, 9999);

            PhoneVerification::updateOrCreate(
                ['phone' => $request->phone],
                [
                    'otp' => $otp,
                    'is_verified' => false,
                    'expires_at' => now()->addMinutes(5),
                ]
            );
            $providerResponse = $sms->sendOTP((string) $request->phone, $otp);

            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully',
                'phone' => $request->phone,
                'provider_debug' => $providerResponse,
            ]);
        } catch (\Exception $e) {
            Log::error('OTP dispatch failed', [
                'phone' => $request->phone,
                'error' => $e->getMessage(),
            ]);

            $message = 'Failed to send OTP. Please try again in a moment.';
            if (str_contains($e->getMessage(), 'website verification')) {
                $message = 'SMS provider account is not verified for OTP API yet. Please complete Fast2SMS OTP website verification.';
            }

            return response()->json([
                'success' => false,
                'message' => $message,
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function testFast2Sms(Request $request, SmsService $sms)
    {
        abort_unless(app()->isLocal() || config('app.debug'), 404);

        $request->validate([
            'token' => ['nullable', 'string'],
            'phone' => ['required', 'regex:/^(91\d{10}|\d{10})$/'],
            'otp' => ['nullable', 'digits:4'],
        ]);

        $configuredToken = (string) config('services.fast2sms.test_token', '');
        if ($configuredToken !== '' && $request->input('token') !== $configuredToken) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid Fast2SMS test token.',
            ], 403);
        }

        try {
            $otp = (string) ($request->input('otp') ?: random_int(1000, 9999));
            $response = $sms->sendOTP((string) $request->input('phone'), $otp);

            return response()->json([
                'success' => true,
                'message' => 'Fast2SMS OTP API call succeeded.',
                'otp' => $otp,
                'provider_response' => $response,
            ]);
        } catch (\Throwable $e) {
            Log::error('Fast2SMS test route failed', [
                'phone' => $request->input('phone'),
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'digits:10'],
            'otp' => ['required', 'digits:4'],
        ]);

        $record = PhoneVerification::where('phone', $request->phone)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired OTP'
            ]);
        }

        $record->update([
            'is_verified' => true
        ]);

        return response()->json([
            'success' => true
        ]);
    }




    public function resetPassword(Request $request)
    {
        $request->validate([
            'phone' => 'required',
            'password' => 'required|confirmed|min:6'
        ]);

        // ✅ Check if phone is verified
        $record = PhoneVerification::where('phone', $request->phone)
            ->where('is_verified', true)
            ->first();

        if (!$record) {
            return back()->withErrors(['otp' => 'OTP not verified']);
        }

        // ✅ Find user
        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return back()->withErrors(['phone' => 'User not found']);
        }

        // ✅ Update password
        $user->password = Hash::make($request->password);
        $user->save();

        // ✅ Clean OTP record
        $record->delete();

        return redirect('/login')->with('success', 'Password reset successful');
    }
}
