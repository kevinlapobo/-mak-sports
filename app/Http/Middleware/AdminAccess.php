<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect()->route('filament.admin.auth.login');
        }

        if (!in_array(auth()->user()->role, ['facility_manager', 'admin'])) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('filament.admin.auth.login')
                ->withErrors(['email' => 'Access denied. Only Facility Managers and Admins can access this area.']);
        }

        return $next($request);
    }
}
