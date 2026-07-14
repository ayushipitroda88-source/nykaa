<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductApprovalController extends Controller
{
    public function index()
    {
        $products = Product::with('seller')->whereNotNull('seller_id')->orderBy('status', 'asc')->get();
        return view('admin.products.approvals', compact('products'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected'
        ]);

        $product = Product::findOrFail($id);
        $product->status = $request->status;
        $product->save();

        return redirect()->back()->with('success', "Product status updated to {$request->status}");
    }
}
