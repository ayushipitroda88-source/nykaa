<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $seller = Auth::guard('seller')->user();
        return view('seller.profile.edit', compact('seller'));
    }

    public function update(Request $request)
    {
        $seller = Auth::guard('seller')->user();
        
        $validated = $request->validate([
            'business_name' => 'required|string|max:255',
            'owner_name' => 'required|string|max:255',
            'email' => 'required|email|unique:sellers,email,' . $seller->id,
            'phone' => 'required|string|max:20',
            'gst_number' => 'nullable|string',
            'pan_number' => 'nullable|string',
            'business_address' => 'required|string',
            'business_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('business_logo')) {
            if ($seller->business_logo) {
                Storage::disk('public')->delete($seller->business_logo);
            }
            $validated['business_logo'] = $request->file('business_logo')->store('seller_logos', 'public');
        }

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:8|confirmed']);
            $validated['password'] = $request->password;
        }

        $seller->update($validated);

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
