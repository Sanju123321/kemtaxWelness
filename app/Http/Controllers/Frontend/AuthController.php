<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\PhoneVerification;
use App\Models\User;
use App\Models\UserTree;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;

use Illuminate\Support\Str;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

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
        $normalizedReference = strtoupper(trim((string) $request->input('reference_code', '')));
        $request->merge([
            'reference_code' => $normalizedReference !== '' ? $normalizedReference : null,
        ]);

        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'email'          => ['required', 'email'],
            'phone'          => ['required', 'digits:10'],
            'reference_code' => ['nullable', 'string', 'max:50', 'regex:/^REF[A-Z0-9]+$/', 'exists:users,reference_code'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ], [
            'reference_code.regex' => 'Reference code must start with REF and contain only letters and numbers (e.g. REFP2WWSX).',
            'reference_code.exists' => 'The provided reference code is invalid. Please enter a valid sponsor reference code.',
        ]);

        $verification = PhoneVerification::where('phone', $request->phone)
            ->where('is_verified', true)
            ->where('expires_at', '>', now())
            ->first();

        if (Session::get('verified_registration_phone') !== $request->phone || !$verification) {
            return back()->withErrors([
                'phone' => 'Please verify OTP before registration',
            ])->withInput($request->except('password', 'password_confirmation'));
        }

        do {
            $userId = 'KW' . str_pad(mt_rand(0, 999999), 6, '0', STR_PAD_LEFT);
        } while (User::where('user_id', $userId)->exists());

        do {
            $referralCode = 'REF' . strtoupper(Str::random(6));
        } while (User::where('reference_code', $referralCode)->exists());

        $referredBy = null;
        $sponsorId = null;
        $parentId = null;
        if (!empty($validated['reference_code'])) {
            $referrer = User::where('reference_code', $validated['reference_code'])->first();

            if ($referrer) {
                $referredBy = $referrer->id;
                $sponsorId = $referrer->id;

                $existingDirects = User::query()
                    ->where(function ($query) use ($referrer) {
                        $query->where('sponsor_id', $referrer->id)
                            ->orWhere(function ($legacy) use ($referrer) {
                                $legacy->whereNull('sponsor_id')
                                    ->where('referred_by', $referrer->id);
                            });
                    })
                    ->count();

                // First 10 directs are auto-placed under sponsor.
                $parentId = $existingDirects < 10 ? $referrer->id : null;
            }
        }

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'reference_code' => $referralCode,
            'user_id' => $userId,
            'referred_by' => $referredBy,
            'sponsor_id' => $sponsorId,
            'parent_id' => $parentId,
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        $this->buildTree($user);

        Session::forget('verified_registration_phone');
        PhoneVerification::where('phone', $request->phone)->delete();

        $message = "Welcome to Kemtex Wellness!\n"
            . "User ID: " . $userId . "\n"
            . "Use your password to login.Thank you for joining us!";

        if ($user->phone) {
            $sms->sendSMS($user->phone, $message);
        }

        if (!empty($validated['reference_code'])) {
            return redirect()->route('member.dashboard')
                ->with('success', 'Welcome! Please complete your plan payment to activate your account.');
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


    public function sendOtp(Request $request, SmsService $sms)
    {
        $request->validate([
            'phone' => ['required', 'digits:10'],
            'purpose' => ['nullable', 'in:registration,password_reset'],
            'user_id' => ['nullable', 'string', 'max:255'],
        ]);


        try {
            $purpose = $request->input('purpose', 'registration');

            if ($purpose === 'password_reset') {
                if (!$request->filled('user_id')) {
                    return response()->json([
                        'success' => false,
                        'message' => 'User ID is required',
                    ], 422);
                }

                $userExists = User::where('user_id', $request->user_id)
                    ->where('phone', $request->phone)
                    ->exists();

                if (!$userExists) {
                    return response()->json([
                        'success' => false,
                        'message' => 'User ID and phone number do not match our records',
                    ], 422);
                }

                Session::forget('verified_password_reset');
            } else {
                Session::forget('verified_registration_phone');
            }

            $otp = rand(100000, 999999);

            PhoneVerification::updateOrCreate(
                ['phone' => $request->phone],
                [
                    'otp' => (string) $otp,
                    'is_verified' => false,
                    'expires_at' => now()->addMinutes(10),
                ]
            );

            $sms->sendOTP($request->phone, $otp);

            return response()->json([
                'success' => true,
                'message' => 'OTP sent successfully',
                'phone' => $request->phone,
            ]);
        } catch (\Exception $e) {
            Log::error('OTP dispatch failed', [
                'phone' => $request->phone,
                'error' => $e->getMessage(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Failed to send OTP',
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
            'otp' => ['required', 'digits:6'],
            'purpose' => ['nullable', 'in:registration,password_reset'],
            'user_id' => ['nullable', 'string', 'max:255'],
        ]);

        $purpose = $request->input('purpose', 'registration');

        if ($purpose === 'password_reset') {
            $userExists = User::where('user_id', $request->user_id)
                ->where('phone', $request->phone)
                ->exists();

            if (!$userExists) {
                return response()->json([
                    'success' => false,
                    'message' => 'User ID and phone number do not match our records',
                ], 422);
            }
        }

        $record = PhoneVerification::where('phone', $request->phone)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if (!$record) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid or expired OTP',
            ]);
        }

        $record->update([
            'is_verified' => true,
        ]);

        if ($purpose === 'password_reset') {
            Session::put('verified_password_reset', [
                'user_id' => $request->user_id,
                'phone' => $request->phone,
            ]);
        } else {
            Session::put('verified_registration_phone', $request->phone);
        }

        return response()->json([
            'success' => true,
        ]);
    }


    public function resetPassword(Request $request)
    {
        $request->validate([
            'user_id' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'digits:10'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $verifiedReset = Session::get('verified_password_reset');

        if (
            !$verifiedReset ||
            ($verifiedReset['user_id'] ?? null) !== $request->user_id ||
            ($verifiedReset['phone'] ?? null) !== $request->phone
        ) {
            return back()->withErrors([
                'otp' => 'Please verify OTP for this user ID and phone number first.',
            ])->withInput($request->except('password', 'password_confirmation'));
        }

        $record = PhoneVerification::where('phone', $request->phone)
            ->where('is_verified', true)
            ->where('expires_at', '>', now())
            ->first();

        if (!$record) {
            return back()->withErrors([
                'otp' => 'OTP not verified or expired.',
            ])->withInput($request->except('password', 'password_confirmation'));
        }

        $user = User::where('user_id', $request->user_id)
            ->where('phone', $request->phone)
            ->first();

        if (!$user) {
            return back()->withErrors([
                'user_id' => 'User ID and phone number do not match our records.',
            ])->withInput($request->except('password', 'password_confirmation'));
        }

        $user->password = Hash::make($request->password);
        $user->save();

        $record->delete();
        Session::forget('verified_password_reset');

        return redirect()->route('login')->with('success', 'Password reset successful');
    }
}
