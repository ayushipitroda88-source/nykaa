<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class VerificationController extends Controller
{
    /**
     * Show the verification status page.
     */
    public function status()
    {
        $seller = Auth::guard('seller')->user();

        if (!$seller) {
            return redirect()->route('seller.login');
        }

        // If approved, redirect to dashboard
        if ($seller->status === 'approved') {
            return redirect()->route('seller.dashboard');
        }

        return view('seller.verification.status', compact('seller'));
    }

    /**
     * Show the resubmission form (edit registration).
     */
    public function edit()
    {
        $seller = Auth::guard('seller')->user();

        if (!$seller || $seller->status !== 'rejected') {
            return redirect()->route('seller.verification.status');
        }

        return view('seller.verification.resubmit', compact('seller'));
    }

    /**
     * Handle the resubmission.
     */
    public function resubmit(Request $request)
    {
        $seller = Auth::guard('seller')->user();

        if (!$seller || $seller->status !== 'rejected') {
            return redirect()->route('seller.verification.status');
        }

        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'email' => 'required|email|unique:sellers,email,' . $seller->id,
            'phone' => 'required|string|max:20',
            'business_address' => 'required|string',
            'gst_number' => 'nullable|string|max:50',
            'pan_number' => 'nullable|string|max:50',
            'business_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('business_logo')) {
            // Delete old logo if exists
            if ($seller->business_logo) {
                Storage::disk('public')->delete($seller->business_logo);
            }
            $validated['business_logo'] = $request->file('business_logo')->store('seller_logos', 'public');
        }

        // Reset status back to pending and clear rejection reason
        $validated['status'] = 'pending';
        $validated['rejection_reason'] = null;
        $validated['rejected_at'] = null;

        $seller->update($validated);

        // Logout seller so they see pending status on next login
        Auth::guard('seller')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('seller.login')->with('success', 'Your application has been resubmitted successfully. The admin will review your updated information.');
    }
}