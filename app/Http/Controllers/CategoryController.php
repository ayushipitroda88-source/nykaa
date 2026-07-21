<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Size;
use App\Models\Collection;
use Illuminate\Database\Eloquent\Builder;

class CategoryController extends Controller
{
    public function index()
    {
        $allCategories = Category::with('children')->get();
        $categories = Category::whereNull('parent_id')
        ->with('children.children')
        ->get();

        return view('categories.index', compact('allCategories', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('categories.create', compact('categories'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'position' => 'nullable|integer',
        ]);
        
        $category = Category::create([
            'name' => $request->name,
            'parent_id' => $request->parent_id ?: null,
            'position' => $request->position ?? 0,
            'status' => 1,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Category add ho gayi!',
            'category' => $category,
        ]);
    }

    public function show($id, Request $request)
    {
        $category = Category::with([
            'children.children',
            'parent',
        ])->findOrFail($id);

        // Current Category + Children + Grand Children
        $categoryIds = collect([$category->id]);

        foreach ($category->children as $child) {
            $categoryIds->push($child->id);
            foreach ($child->children as $sub) {
                $categoryIds->push($sub->id);
            }
        }

        // ===== FILTER LOGIC =====
        $query = Product::whereIn('category_id', $categoryIds)
            ->where('status', 'approved');

        // Sort
        $sort = $request->sort ?? 'newest';
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'name_asc':
                $query->orderBy('title', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('title', 'desc');
                break;
            default:
                $query->latest();
                break;
        }

        // Brand filter
        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }

        // Category filter (overrides main category)
        if ($request->filled('category')) {
            $filterCatIds = collect([$request->category]);
            $filterCat = Category::with('children.children')->find($request->category);
            if ($filterCat) {
                foreach ($filterCat->children as $child) {
                    $filterCatIds->push($child->id);
                    foreach ($child->children as $sub) {
                        $filterCatIds->push($sub->id);
                    }
                }
            }
            $query->whereIn('category_id', $filterCatIds);
        }

        // Price filter
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // In stock filter
        if ($request->filled('in_stock')) {
            $query->where('quantity', '>', 0);
        }

        // Color filter
        if ($request->filled('color')) {
            $query->whereHas('colors', function ($q) use ($request) {
                $q->where('colors.id', $request->color);
            });
        }

        // Size filter
        if ($request->filled('size')) {
            $query->whereHas('sizes', function ($q) use ($request) {
                $q->where('sizes.id', $request->size);
            });
        }

        // Discount filter (approximate - products in collections with discount)
        if ($request->filled('discount')) {
            $discount = $request->discount;
            $query->whereHas('collections', function ($q) use ($discount) {
                $q->where('discount', '>=', $discount)
                  ->where('status', 1)
                  ->where('discount_start', '<=', now())
                  ->where('discount_end', '>=', now());
            });
        }

        // Collection filter
        if ($request->filled('collection')) {
            $query->whereHas('collections', function ($q) use ($request) {
                $q->where('collections.id', $request->collection);
            });
        }

        // Eager load
        $query->with(['category', 'brand', 'collections', 'colors', 'sizes', 'variants.color', 'variants.sizes']);

        $products = $query->paginate(12)->withQueryString();

        // ===== FILTER DATA =====
        $filterBrands = Brand::whereHas('products', function ($q) use ($categoryIds) {
            $q->whereIn('category_id', $categoryIds)->where('status', 'approved');
        })->withCount(['products' => function ($q) use ($categoryIds) {
            $q->whereIn('category_id', $categoryIds)->where('status', 'approved');
        }])->get();

        $filterColors = Color::whereHas('products', function ($q) use ($categoryIds) {
            $q->whereIn('category_id', $categoryIds)->where('status', 'approved');
        })->get();

        $filterSizes = Size::whereHas('products', function ($q) use ($categoryIds) {
            $q->whereIn('category_id', $categoryIds)->where('status', 'approved');
        })->get();

        $filterCollections = Collection::where('status', 1)
            ->whereHas('products', function ($q) use ($categoryIds) {
                $q->whereIn('category_id', $categoryIds)->where('status', 'approved');
            })->get();

        return view('user.category', compact(
            'category',
            'products',
            'filterBrands',
            'filterColors',
            'filterSizes',
            'filterCollections'
        ));
    }
    
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'position' => 'nullable|integer',
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'name' => $request->name,
            'position' => $request->position ?? $category->position,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Naam update ho gaya!',
            'category' => $category,
        ]);
    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();

        return response()->json([
            'success' => true,
            'message' => 'Category delete ho gayi!',
        ]);
    }
}