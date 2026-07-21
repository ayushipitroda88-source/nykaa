<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\Color;
use Illuminate\Http\Request;

class SellerColorController extends Controller
{
    /**
     * Display colors belonging to a specific seller.
     */
    public function index(Request $request, Seller $seller)
    {
        $query = $seller->colors();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('color_code', 'like', "%{$search}%");
            });
        }

        $colors = $query->latest()->paginate(10);

        return view('admin.sellers.colors', compact('seller', 'colors'));
    }

    /**
     * Delete a color belonging to a seller.
     */
    public function destroy(Seller $seller, Color $color)
    {
        // Ensure the color belongs to this seller
        if ($color->seller_id !== $seller->id) {
            return redirect()->back()->with('error', 'This color does not belong to this seller.');
        }

        $color->delete();

        return redirect()->route('admin.sellers.colors', $seller->id)
            ->with('success', 'Color deleted successfully.');
    }
}