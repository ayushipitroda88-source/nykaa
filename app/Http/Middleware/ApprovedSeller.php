<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ApprovedSeller
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $seller = Auth::guard('seller')->user();

        if (!$seller || $seller->status !== 'approved') {
            if ($seller && in_array($seller->status, ['rejected', 'suspended'])) {
                Auth::guard('seller')->logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                return redirect()->route('seller.login')->withErrors(['email' => 'Your account has been ' . $seller->status]);
            }
            return redirect()->route('seller.login')->with('success', 'Your account is pending admin approval.');
        }

        return $next($request);
    }
}
