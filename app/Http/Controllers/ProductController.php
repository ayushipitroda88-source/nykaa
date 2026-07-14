<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Collection;  
use App\Models\Brand;
use App\Models\Color;
use App\Models\Size;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function create()
    {
        $mainCategories = Category::whereNull('parent_id')
            ->orderBy('position')
            ->get();

        $collections = Collection::all();
        $brands = Brand::where('status', 1)->get();
        $colors = Color::where('status', 1)->get();
        $sizes = Size::where('status', 1)->get();

        return view('product.create', compact('mainCategories', 'collections', 'brands', 'colors', 'sizes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'image' => 'required|image',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'collections' => 'nullable|array',
            'quantity' => 'required|integer|min:0',
            'brand_id' => 'nullable|exists:brands,id',
            'colors' => 'nullable|array',
            'colors.*' => 'exists:colors,id',
            'sizes' => 'nullable|array',
            'sizes.*' => 'exists:sizes,id',
        ]);

        // Image upload
        $file = $request->file('image');
        $name = time() . '.' . $file->extension();
        $file->move(public_path('uploads'), $name);

        // Create product
        $product = Product::create([
            'title' => $request->title,
            'image' => $name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'price' => $request->price,
            'quantity' => $request->quantity,
        ]);

        // Attach collections (BEST WAY)
        if ($request->filled('collections')) {
            $product->collections()->sync($request->collections);
        }

        // Attach colors
        if ($request->filled('colors')) {
            $product->colors()->sync($request->colors);
        }

        // Attach sizes
        if ($request->filled('sizes')) {
            $product->sizes()->sync($request->sizes);
        }

        return redirect('/products')->with('success', 'Product created successfully');
    }    public function index()
    {
        $products = Product::with(['category', 'brand', 'collections', 'colors', 'sizes'])->get();
        return view('product.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::with(['category', 'collections', 'brand', 'colors', 'sizes'])->findOrFail($id);

        $collectionId = request()->query('collection_id');
        $collection = null;
        $discountedPrice = $product->price;
        $hasDiscount = false;

        if ($collectionId) {
            $collection = $product->collections()
                ->where('collections.id', $collectionId)
                ->first();

            if (
                $collection &&
                $collection->discount > 0 &&
                $collection->discount_start &&
                $collection->discount_end &&
                now()->between($collection->discount_start, $collection->discount_end)
            ) {
                $hasDiscount = true;
                $discountedPrice = $product->price - ($product->price * $collection->discount / 100);
            } else {
                $collectionId = null;
            }
        }

        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        // Header ke liye categories
        $categories = Category::with('children')
            ->whereNull('parent_id')
            ->orderBy('position')
            ->get();

        return view('user.product-details', compact(
            'product',
            'relatedProducts',
            'categories',
            'collectionId',
            'collection',
            'hasDiscount',
            'discountedPrice'
        ));
    }
    public function edit($id)
    {
        $product = Product::with(['colors', 'sizes'])->findOrFail($id);

        $mainCategories = Category::whereNull('parent_id')
            ->orderBy('position')
            ->get();

        $collections = Collection::all();
        $brands = Brand::where('status', 1)->get();
        $colors = Color::where('status', 1)->get();
        $sizes = Size::where('status', 1)->get();

        // Current Category
        $childCategory = Category::find($product->category_id);

        $subCategory = null;
        $mainCategory = null;

        if ($childCategory) {
            $subCategory = $childCategory->parent;

            if ($subCategory) {
                $mainCategory = $subCategory->parent;
            }
        }

        return view('product.edit', compact(
            'product',
            'mainCategories',
            'collections',
            'brands',
            'colors',
            'sizes',
            'mainCategory',
            'subCategory',
            'childCategory'
        ));
    }
public function getSubCategories($id)
{
    $categories = Category::where('parent_id', $id)
        ->orderBy('position')
        ->get();

    return response()->json($categories);
}

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'collections' => 'nullable|array',
            'brand_id' => 'nullable|exists:brands,id',
            'colors' => 'nullable|array',
            'colors.*' => 'exists:colors,id',
            'sizes' => 'nullable|array',
            'sizes.*' => 'exists:sizes,id',
        ]);

        // Update product fields
        $product->title = $request->title;
        $product->description = $request->description;
        $product->category_id = $request->category_id;
        $product->brand_id = $request->brand_id;
        $product->price = $request->price;
        $product->quantity = $request->quantity;

        // Image update
        if ($request->hasFile('image')) {

            $file = $request->file('image');
            $name = time() . '.' . $file->extension();
            $file->move(public_path('uploads'), $name);

            $product->image = $name;
        }

        $product->save();

        // Many-to-many sync (BEST WAY)
        $product->collections()->sync($request->collections ?? []);
        $product->colors()->sync($request->colors ?? []);
        $product->sizes()->sync($request->sizes ?? []);

        return redirect('/products')->with('success', 'Product updated successfully');
    }
public function destroy($id)
{
    $product = Product::findOrFail($id);

    if (file_exists(public_path('uploads/'.$product->image))) {
        unlink(public_path('uploads/'.$product->image));
    }

    $product->delete();

    return redirect('/products');
}

public function search(Request $request)
{
    $categories = Category::whereNull('parent_id')
                    ->with('children')
                    ->get();

    $search = $request->search;
    $brand_id = $request->brand_id;

    $products = Product::with('category')
        ->when($search, function($query) use ($search) {
            $query->where(function($q) use ($search) {
                $q->where('title', 'LIKE', '%' . $search . '%')
                  ->orWhere('description', 'LIKE', '%' . $search . '%');
            });
        })
        ->when($brand_id, function($query) use ($brand_id) {
            $query->where('brand_id', $brand_id);
        })
        ->get();

    $brand = null;
    if ($brand_id) {
        $brand = Brand::find($brand_id);
    }

    return view('user.search', compact('products', 'categories', 'brand', 'search'));
}
}