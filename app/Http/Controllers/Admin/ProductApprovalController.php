<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductApprovalController extends Controller
{
    /**
     * Display the product approval page with tabbed filtering.
     *
     * Tabs: All, Pending, Resubmitted, Approved, Rejected
     */
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'pending');

        $query = Product::with(['seller', 'category', 'brand'])
            ->whereNotNull('seller_id'); // Only seller products need approval

        // Apply tab filter
        switch ($tab) {
            case 'pending':
                $query->where('status', 'pending');
                break;
            case 'resubmitted':
                $query->where('status', 'resubmitted');
                break;
            case 'approved':
                $query->where('status', 'approved');
                break;
            case 'rejected':
                $query->where('status', 'rejected');
                break;
            case 'all':
                // No filter - show all seller products
                break;
            default:
                $tab = 'pending';
                $query->where('status', 'pending');
        }

        $products = $query->latest()->get();

        // Get counts for badge display
        $counts = [
            'all'         => Product::whereNotNull('seller_id')->count(),
            'pending'     => Product::whereNotNull('seller_id')->where('status', 'pending')->count(),
            'resubmitted' => Product::whereNotNull('seller_id')->where('status', 'resubmitted')->count(),
            'approved'    => Product::whereNotNull('seller_id')->where('status', 'approved')->count(),
            'rejected'    => Product::whereNotNull('seller_id')->where('status', 'rejected')->count(),
        ];

        return view('admin.products.approvals', compact('products', 'tab', 'counts'));
    }

    /**
     * Show the full product review detail page for admin.
     * Works for any status: pending, resubmitted, approved, rejected.
     */
    public function review($id)
    {
        $product = Product::with(['seller', 'category', 'brand', 'approver', 'variants.color', 'variants.sizes'])
            ->whereNotNull('seller_id')
            ->findOrFail($id);

        return view('admin.products.review', compact('product'));
    }

    /**
     * Approve a seller product.
     *
     * Sets status to 'approved', records who approved it and when.
     * Clears any existing rejection reason.
     */
    public function approve($id)
    {
        $product = Product::whereNotNull('seller_id')->findOrFail($id);

        $product->status = 'approved';
        $product->approved_by = Auth::guard('admin')->id();
        $product->approved_at = now();
        $product->rejection_reason = null;
        $product->save();

        return redirect()->back()->with('success', "Product '{$product->title}' has been approved successfully.");
    }

    /**
     * Reject a seller product with a mandatory reason.
     *
     * Opens a modal (handled via session flash for the modal).
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|min:10|max:1000',
        ]);

        $product = Product::whereNotNull('seller_id')->findOrFail($id);

        $product->status = 'rejected';
        $product->rejection_reason = $request->rejection_reason;
        $product->approved_by = null;
        $product->approved_at = null;
        $product->save();

        return redirect()->back()->with('success', "Product '{$product->title}' has been rejected.");
    }

    /**
     * Resubmit a rejected product (seller side action).
     * Called when seller clicks Resubmit after editing rejected product.
     */
    public function resubmit($id)
    {
        $product = Product::where('seller_id', Auth::guard('seller')->id())
            ->where('status', 'rejected')
            ->findOrFail($id);

        $product->status = 'resubmitted';
        $product->rejection_reason = null;
        $product->approved_by = null;
        $product->approved_at = null;
        $product->save();

        return redirect()->back()->with('success', 'Product has been resubmitted for approval.');
    }
}