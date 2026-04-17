<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        // Admin users bypass maintenance mode
        if (Auth::check() && Auth::user()->email === 'admin@kemtex.com') {
            return $next($request);
        }

        if (Setting::getValue('maintenance_mode', '0') == '1') {
            return response()->view('maintenance', [], 503);
        }

        return $next($request);
    }
}
