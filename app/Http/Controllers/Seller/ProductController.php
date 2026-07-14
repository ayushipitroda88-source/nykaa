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
        $brands = Brand::all();
        return view('seller.products.create', compact('mainCategories', 'brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ]);

        $file = $request->file('image');
        $name = time() . '.' . $file->extension();
        $file->move(public_path('uploads'), $name);
        $validated['image'] = $name;

        $validated['seller_id'] = Auth::guard('seller')->id();
        $validated['status'] = 'pending';

        $product = Product::create($validated);

        return redirect()->route('seller.variants.index', $product->id)->with('success', 'Product created. Now add variants.');
    }

    public function edit($id)
    {
        $product = Product::where('seller_id', Auth::guard('seller')->id())->findOrFail($id);
        
        $mainCategories = Category::whereNull('parent_id')->orderBy('position')->get();
        $brands = Brand::all();
        
        $childCategory = Category::find($product->category_id);
        $subCategory = null;
        $mainCategory = null;

        if ($childCategory) {
            $subCategory = $childCategory->parent;
            if ($subCategory) {
                $mainCategory = $subCategory->parent;
            }
        }

        return view('seller.products.edit', compact('product', 'mainCategories', 'brands', 'mainCategory', 'subCategory', 'childCategory'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::where('seller_id', Auth::guard('seller')->id())->findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $name = time() . '.' . $file->extension();
            $file->move(public_path('uploads'), $name);
            $validated['image'] = $name;
        }

        $product->update($validated);

        return redirect()->route('seller.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy($id)
    {
        $product = Product::where('seller_id', Auth::guard('seller')->id())->findOrFail($id);
        $product->delete();
        return redirect()->route('seller.products.index')->with('success', 'Product deleted successfully.');
    }
}
