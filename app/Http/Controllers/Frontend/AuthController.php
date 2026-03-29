<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rules;

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
            'email'    => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended(route('member.dashboard'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
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
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name'           => ['required', 'string', 'max:255'],
            'email'          => ['required', 'email', 'unique:users,email'],
            'phone'          => ['nullable', 'string', 'max:20'],
            'reference_code' => ['nullable', 'string', 'max:50'],
            'password'       => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Check if reference code exists (if provided)
        $referredBy = null;
        if (!empty($validated['reference_code'])) {
            $referrer = User::where('email', $validated['reference_code'])
                ->orWhere('id', $validated['reference_code'])
                ->first();
            
            if ($referrer) {
                $referredBy = $referrer->id;
            }
        }

        $user = User::create([
            'name'          => $validated['name'],
            'email'         => $validated['email'],
            'phone'         => $validated['phone'] ?? null,
            'reference_code' => $validated['reference_code'] ?? null,
            'referred_by'   => $referredBy,
            'password'      => Hash::make($validated['password']),
        ]);

        Auth::login($user);

        // Redirect based on reference code
        if (!empty($validated['reference_code'])) {
            return redirect()->route('member.setup')
                ->with('success', 'Welcome! Please complete your plan payment to activate your account.');
        }

        return redirect()->route('member.dashboard')
            ->with('success', 'Welcome to Kemtex Wellness! Your account has been created successfully.');
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
}
