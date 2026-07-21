<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class SizeController extends Controller
{
    /**
     * Display a listing of the seller's sizes.
     */
    public function index()
    {
        $sellerId = Auth::guard('seller')->id();
        $sizes = Size::forSeller($sellerId)->latest()->get();
        return view('seller.sizes.index', compact('sizes'));
    }

    /**
     * Store a newly created size.
     */
    public function store(Request $request)
    {
        $sellerId = Auth::guard('seller')->id();

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sizes')->where(function ($query) use ($sellerId) {
                    return $query->where('seller_id', $sellerId);
                }),
            ],
            'status' => 'required|in:0,1',
        ]);

        Size::create([
            'name' => $request->name,
            'status' => $request->status,
            'seller_id' => $sellerId,
        ]);

        return back()->with('success', 'Size added successfully.');
    }

    /**
     * Update the specified size.
     */
    public function update(Request $request, $id)
    {
        $sellerId = Auth::guard('seller')->id();
        $size = Size::forSeller($sellerId)->findOrFail($id);

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sizes')->where(function ($query) use ($sellerId) {
                    return $query->where('seller_id', $sellerId);
                })->ignore($size->id),
            ],
            'status' => 'required|in:0,1',
        ]);

        $size->update([
            'name' => $request->name,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Size updated successfully.');
    }

    /**
     * Remove the specified size.
     */
    public function destroy($id)
    {
        $sellerId = Auth::guard('seller')->id();
        $size = Size::forSeller($sellerId)->findOrFail($id);
        $size->delete();

        return back()->with('success', 'Size deleted successfully.');
    }
}