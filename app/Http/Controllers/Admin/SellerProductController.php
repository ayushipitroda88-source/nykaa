<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;

class SellerProductController extends Controller
{
    /**
     * Display products belonging to a specific seller.
     */
    public function index(Request $request, Seller $seller)
    {
        $query = $seller->products()->with(['category', 'brand']);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status') && in_array($request->status, ['pending', 'approved', 'rejected', 'resubmitted'])) {
            $query->where('status', $request->status);
        }

        $products = $query->latest()->paginate(10);

        $statusCounts = [
            'all' => $seller->products()->count(),
            'pending' => $seller->products()->where('status', 'pending')->count(),
            'approved' => $seller->products()->where('status', 'approved')->count(),
            'rejected' => $seller->products()->where('status', 'rejected')->count(),
            'resubmitted' => $seller->products()->where('status', 'resubmitted')->count(),
        ];

        $currentStatus = $request->query('status', 'all');

        return view('admin.sellers.products', compact('seller', 'products', 'statusCounts', 'currentStatus'));
    }
}