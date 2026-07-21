<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use App\Models\Size;
use Illuminate\Http\Request;

class SellerSizeController extends Controller
{
    /**
     * Display sizes belonging to a specific seller.
     */
    public function index(Request $request, Seller $seller)
    {
        $query = $seller->sizes();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $sizes = $query->latest()->paginate(10);

        return view('admin.sellers.sizes', compact('seller', 'sizes'));
    }

    /**
     * Delete a size belonging to a seller.
     */
    public function destroy(Seller $seller, Size $size)
    {
        // Ensure the size belongs to this seller
        if ($size->seller_id !== $seller->id) {
            return redirect()->back()->with('error', 'This size does not belong to this seller.');
        }

        $size->delete();

        return redirect()->route('admin.sellers.sizes', $seller->id)
            ->with('success', 'Size deleted successfully.');
    }
}