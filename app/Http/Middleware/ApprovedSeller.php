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

        if (!$seller) {
            return redirect()->route('seller.login');
        }

        // Rejected sellers: redirect to verification status page
        if ($seller->status === 'rejected') {
            return redirect()->route('seller.verification.status');
        }

        // Suspended sellers: redirect to verification status page
        if ($seller->status === 'suspended') {
            return redirect()->route('seller.verification.status');
        }

        // Pending sellers: redirect to verification status page
        if ($seller->status === 'pending') {
            return redirect()->route('seller.verification.status');
        }

        // Only approved sellers can proceed
        return $next($request);
    }
}
