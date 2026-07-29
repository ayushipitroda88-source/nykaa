<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Seller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class SellerManagementController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab', 'all');

        $counts = [
            'all' => Seller::count(),
            'pending' => Seller::where('status', 'pending')->count(),
            'approved' => Seller::where('status', 'approved')->count(),
            'rejected' => Seller::where('status', 'rejected')->count(),
            'suspended' => Seller::where('status', 'suspended')->count(),
        ];

        $query = Seller::query()->withCount(['colors', 'sizes']);

        if ($tab !== 'all' && in_array($tab, ['pending', 'approved', 'rejected', 'suspended'])) {
            $query->where('status', $tab);
        }

        $sellers = $query->latest()->paginate(10);

        return view('admin.sellers.index', compact('sellers', 'tab', 'counts'));
    }

    public function show($id)
    {
        $seller = Seller::withCount(['products', 'colors', 'sizes'])->findOrFail($id);
        return view('admin.sellers.show', compact('seller'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected,suspended',
            'rejection_reason' => 'required_if:status,rejected',
            'suspension_reason' => 'required_if:status,suspended'
        ]);

        $seller = Seller::findOrFail($id);
        $oldStatus = $seller->status;
        $seller->status = $request->status;
        
        if ($request->status === 'rejected') {
            $seller->rejection_reason = $request->rejection_reason;
            $seller->rejected_at = now();
            // Clear suspension fields when rejecting
            $seller->suspension_reason = null;
            $seller->suspended_at = null;
        } elseif ($request->status === 'suspended') {
            $seller->suspension_reason = $request->suspension_reason;
            $seller->suspended_at = now();
        } elseif ($request->status === 'approved') {
            // Clear all rejection/suspension data when approving
            $seller->rejection_reason = null;
            $seller->rejected_at = null;
            $seller->suspension_reason = null;
            $seller->suspended_at = null;
        } elseif ($request->status === 'pending') {
            // Keep existing rejection info but allow admin to set pending manually
        }
        
        $seller->save();

        // Flash messages based on status change
        $messages = [
            'approved' => 'Seller has been approved successfully. They can now access their seller dashboard.',
            'rejected' => 'Seller has been rejected with the provided reason.',
            'suspended' => 'Seller has been suspended.',
            'pending' => 'Seller status has been set to pending.',
        ];

        $message = $messages[$request->status] ?? "Seller status updated to {$request->status}";

        return redirect()->back()->with('success', $message);
    }

    public function products(Request $request, $id)
    {
        $seller = Seller::findOrFail($id);
        
        $currentStatus = $request->query('status', 'all');
        $search = $request->query('search');

        $query = $seller->products()->with(['category', 'brand']);

        if ($currentStatus !== 'all') {
            $query->where('status', $currentStatus);
        }

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        $products = $query->latest()->paginate(15);

        $statusCounts = [
            'all' => $seller->products()->count(),
            'pending' => $seller->products()->where('status', 'pending')->count(),
            'resubmitted' => $seller->products()->where('status', 'resubmitted')->count(),
            'approved' => $seller->products()->where('status', 'approved')->count(),
            'rejected' => $seller->products()->where('status', 'rejected')->count(),
        ];

        return view('admin.sellers.products', compact('seller', 'products', 'currentStatus', 'statusCounts'));
    }

    public function colors(Request $request, $id)
    {
        $seller = Seller::findOrFail($id);
        
        $search = $request->query('search');
        $query = $seller->colors();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('color_code', 'like', "%{$search}%");
            });
        }

        $colors = $query->latest()->paginate(15);
        return view('admin.sellers.colors', compact('seller', 'colors'));
    }

    public function destroyColor($sellerId, $colorId)
    {
        $color = \App\Models\Color::where('seller_id', $sellerId)->findOrFail($colorId);
        $color->delete();
        return back()->with('success', 'Color deleted successfully.');
    }

    public function sizes(Request $request, $id)
    {
        $seller = Seller::findOrFail($id);
        
        $search = $request->query('search');
        $query = $seller->sizes();

        if ($search) {
            $query->where('name', 'like', "%{$search}%");
        }

        $sizes = $query->latest()->paginate(15);
        return view('admin.sellers.sizes', compact('seller', 'sizes'));
    }

    public function destroySize($sellerId, $sizeId)
    {
        $size = \App\Models\Size::where('seller_id', $sellerId)->findOrFail($sizeId);
        $size->delete();
        return back()->with('success', 'Size deleted successfully.');
    }
}
