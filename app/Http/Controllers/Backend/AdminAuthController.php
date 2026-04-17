<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class AdminAuthController extends Controller
{
    /**
     * Show the admin login form.
     */
    public function showLogin()
    {
        return view('backend.auth.login');
    }

    /**
     * Handle admin login request.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => ['required', 'email:rfc,dns'],
            'password' => ['required', 'string', 'min:6'],
        ], [
            'email.required'    => 'Email address is required.',
            'email.email'       => 'Please enter a valid email address.',
            'password.required' => 'Password is required.',
            'password.min'      => 'Password must be at least 6 characters.',
        ]);

        // Rate limiting: max 5 attempts per email+IP per minute
        $throttleKey = 'admin-login.' . Str::lower($request->email) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            return back()->withErrors([
                'email' => "Too many login attempts. Please wait {$seconds} seconds before trying again.",
            ])->onlyInput('email');
        }

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            RateLimiter::clear($throttleKey);
            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'));
        }

        RateLimiter::hit($throttleKey, 60);
        $remaining = 5 - RateLimiter::attempts($throttleKey);

        return back()->withErrors([
            'email' => $remaining > 0
                ? "Invalid email or password. {$remaining} attempt(s) remaining."
                : 'Too many login attempts. Please wait before trying again.',
        ])->onlyInput('email');
    }

    /**
     * Show the admin registration form.
     */
    public function showRegister()
    {
        return view('backend.auth.register');
    }

    /**
     * Handle admin registration request.
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name'     => $validated['name'],
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Admin account created successfully.');
    }

    /**
     * Handle admin logout request.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'You have been logged out successfully.');
    }

    /**
     * Show change password form (for logged-in admin).
     */
    public function showChangePassword()
    {
        return view('backend.auth.change-password');
    }

    /**
     * Handle change password request (for logged-in admin).
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required'],
            'password'         => ['required', 'confirmed', 'min:8'],
        ]);

        $admin = Auth::user();

        if (!Hash::check($request->current_password, $admin->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        $admin->update(['password' => Hash::make($request->password)]);

        return back()->with('success', 'Password changed successfully.');
    }

    /**
     * Show forgot password form.
     */
    public function showForgotPassword()
    {
        return view('backend.auth.forgot-password');
    }

    /**
     * Handle forgot password — two-step: verify email, then reset password.
     */
    public function forgotPassword(Request $request)
    {
        if ($request->input('step') === 'verify_email') {
            $request->validate(['email' => ['required', 'email']]);

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return back()->withErrors(['email' => 'No admin account found with this email address.']);
            }

            // Store verified email in session for step 2
            $request->session()->put('reset_email', $request->email);

            return back()->with('success', 'Email verified. Please set your new password.');
        }

        if ($request->input('step') === 'reset_password') {
            $request->validate([
                'email'    => ['required', 'email'],
                'password' => ['required', 'confirmed', 'min:8'],
            ]);

            $resetEmail = $request->session()->get('reset_email');

            // Ensure the posted email matches the session-verified one
            if (!$resetEmail || $resetEmail !== $request->email) {
                $request->session()->forget('reset_email');
                return redirect()->route('admin.forgot.password')
                    ->withErrors(['email' => 'Session expired. Please start again.']);
            }

            $user = User::where('email', $resetEmail)->first();

            if (!$user) {
                $request->session()->forget('reset_email');
                return redirect()->route('admin.forgot.password')
                    ->withErrors(['email' => 'Account not found.']);
            }

            $user->update(['password' => Hash::make($request->password)]);
            $request->session()->forget('reset_email');

            return redirect()->route('admin.login')
                ->with('success', 'Password updated successfully. Please login with your new password.');
        }

        return redirect()->route('admin.forgot.password');
    }
}
