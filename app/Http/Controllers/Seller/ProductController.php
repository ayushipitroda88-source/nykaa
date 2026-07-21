<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::where('seller_id', Auth::guard('seller')->id())->get();
        return view('seller.products.index', compact('products'));
    }

    public function create()
    {
        $mainCategories = Category::whereNull('parent_id')->orderBy('position')->get();
        return view('seller.products.create', compact('mainCategories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $seller = Auth::guard('seller')->user();
        
        // Auto-resolve Brand based on seller's business_name
        $brand = Brand::firstOrCreate(
            ['name' => $seller->business_name],
            ['status' => 1, 'slug' => \Illuminate\Support\Str::slug($seller->business_name)]
        );

        $validated['brand_id'] = $brand->id;
        $validated['seller_id'] = $seller->id;
        $validated['status'] = 'pending';
        // Set default values for dropped fields that are still required by admin products
        $validated['price'] = 0;
        $validated['quantity'] = 0;
        $validated['image'] = '';

        $product = Product::create($validated);

        return redirect()->route('seller.variants.index', $product->id)->with('success', 'Product created. Now add variants.');
    }

    public function edit($id)
    {
        $product = Product::where('seller_id', Auth::guard('seller')->id())->findOrFail($id);
        
        $mainCategories = Category::whereNull('parent_id')->orderBy('position')->get();
        
        $childCategory = Category::find($product->category_id);
        $subCategory = null;
        $mainCategory = null;

        if ($childCategory) {
            $subCategory = $childCategory->parent;
            if ($subCategory) {
                $mainCategory = $subCategory->parent;
            }
        }

        return view('seller.products.edit', compact('product', 'mainCategories', 'mainCategory', 'subCategory', 'childCategory'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::where('seller_id', Auth::guard('seller')->id())->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
        ]);

        $product->update($validated);

        // If the product was rejected and seller is saving changes, 
        // check if they want to resubmit (handled via separate resubmit button)
        return redirect()->route('seller.products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Resubmit a rejected product for approval.
     * Seller must save changes first before resubmitting.
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

        return redirect()->route('seller.products.index')->with('success', 'Product has been resubmitted for approval.');
    }

    public function destroy($id)
    {
        $product = Product::where('seller_id', Auth::guard('seller')->id())->findOrFail($id);
        $product->delete();
        return redirect()->route('seller.products.index')->with('success', 'Product deleted successfully.');
    }
}
