<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ColorController extends Controller
{
    /**
     * Display a listing of the seller's colors.
     */
    public function index()
    {
        $sellerId = Auth::guard('seller')->id();
        $colors = Color::forSeller($sellerId)->latest()->get();
        return view('seller.colors.index', compact('colors'));
    }

    /**
     * Store a newly created color.
     */
    public function store(Request $request)
    {
        $sellerId = Auth::guard('seller')->id();

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('colors')->where(function ($query) use ($sellerId) {
                    return $query->where('seller_id', $sellerId);
                }),
            ],
            'color_code' => 'required|string|max:20',
            'status' => 'required|in:0,1',
        ]);

        Color::create([
            'name' => $request->name,
            'color_code' => $request->color_code,
            'status' => $request->status,
            'seller_id' => $sellerId,
        ]);

        return back()->with('success', 'Color added successfully.');
    }

    /**
     * Update the specified color.
     */
    public function update(Request $request, $id)
    {
        $sellerId = Auth::guard('seller')->id();
        $color = Color::forSeller($sellerId)->findOrFail($id);

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('colors')->where(function ($query) use ($sellerId) {
                    return $query->where('seller_id', $sellerId);
                })->ignore($color->id),
            ],
            'color_code' => 'required|string|max:20',
            'status' => 'required|in:0,1',
        ]);

        $color->update([
            'name' => $request->name,
            'color_code' => $request->color_code,
            'status' => $request->status,
        ]);

        return back()->with('success', 'Color updated successfully.');
    }

    /**
     * Remove the specified color.
     */
    public function destroy($id)
    {
        $sellerId = Auth::guard('seller')->id();
        $color = Color::forSeller($sellerId)->findOrFail($id);
        $color->delete();

        return back()->with('success', 'Color deleted successfully.');
    }
}