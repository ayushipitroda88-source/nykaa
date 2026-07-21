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

        // Create product - Admin products auto-approved
        $product = Product::create([
            'title' => $request->title,
            'image' => $name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'brand_id' => $request->brand_id,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'status' => 'approved', // Admin products are auto-approved
        ]);

        // Attach collections
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
    }    
    public function index()
    {
        $products = Product::with(['category', 'brand', 'collections', 'colors', 'sizes'])->get();
        return view('product.index', compact('products'));
    }

    public function show($id)
    {
        $product = Product::with(['category', 'collections', 'brand', 'colors', 'sizes'])->where('status', 'approved')->findOrFail($id);

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
            ->where('status', 'approved')
            ->take(4)
            ->get();

        return view('user.product-details', compact(
            'product',
            'relatedProducts',
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

        // Many-to-many sync
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
        $search = $request->search;
        $sort = $request->sort ?? 'newest';
        $brand_id = $request->brand;
        $seller_id = $request->seller_id;
        $minPrice = $request->min_price;
        $maxPrice = $request->max_price;
        $inStock = $request->in_stock;
        $colorId = $request->color;
        $sizeId = $request->size;
        $discount = $request->discount;
        $collectionId = $request->collection;
        $categoryId = $request->category;

        $products = Product::with(['category', 'brand', 'colors', 'sizes', 'collections', 'variants.color'])
            ->where('status', 'approved')
            ->when($search, function($query) use ($search) {
                $query->where(function($q) use ($search) {
                    $q->where('title', 'LIKE', '%' . $search . '%')
                      ->orWhere('description', 'LIKE', '%' . $search . '%');
                });
            })
            ->when($brand_id, function($query) use ($brand_id) {
                $query->where('brand_id', $brand_id);
            })
            ->when($seller_id, function($query) use ($seller_id) {
                $query->where('seller_id', $seller_id);
            })
            ->when($minPrice, function($query) use ($minPrice) {
                $query->where('price', '>=', $minPrice);
            })
            ->when($maxPrice, function($query) use ($maxPrice) {
                $query->where('price', '<=', $maxPrice);
            })
            ->when($inStock, function($query) {
                $query->where('quantity', '>', 0);
            })
            ->when($colorId, function($query) use ($colorId) {
                $query->whereHas('colors', function($q) use ($colorId) {
                    $q->where('colors.id', $colorId);
                });
            })
            ->when($sizeId, function($query) use ($sizeId) {
                $query->whereHas('sizes', function($q) use ($sizeId) {
                    $q->where('sizes.id', $sizeId);
                });
            })
            ->when($discount, function($query) use ($discount) {
                $query->whereHas('collections', function($q) use ($discount) {
                    $q->where('discount', '>=', $discount)
                      ->where('status', 1)
                      ->where('discount_start', '<=', now())
                      ->where('discount_end', '>=', now());
                });
            })
            ->when($collectionId, function($query) use ($collectionId) {
                $query->whereHas('collections', function($q) use ($collectionId) {
                    $q->where('collections.id', $collectionId);
                });
            })
            ->when($categoryId, function($query) use ($categoryId) {
                $catIds = collect([$categoryId]);
                $cat = Category::with('children.children')->find($categoryId);
                if ($cat) {
                    foreach ($cat->children as $child) {
                        $catIds->push($child->id);
                        foreach ($child->children as $sub) {
                            $catIds->push($sub->id);
                        }
                    }
                }
                $query->whereIn('category_id', $catIds);
            });

        // Sort
        switch ($sort) {
            case 'price_asc': $products->orderBy('price', 'asc'); break;
            case 'price_desc': $products->orderBy('price', 'desc'); break;
            case 'name_asc': $products->orderBy('title', 'asc'); break;
            case 'name_desc': $products->orderBy('title', 'desc'); break;
            default: $products->latest(); break;
        }

        $products = $products->paginate(12)->withQueryString();

        // Filter data for sidebar
        $filterCollections = Collection::where('status', 1)
            ->whereHas('products', function($q) {
                $q->where('status', 'approved');
            })->get();

        $filterBrands = Brand::whereHas('products', function($q) {
                $q->where('status', 'approved');
            })->withCount(['products' => function($q) {
                $q->where('status', 'approved');
            }])->get();

        $filterColors = Color::whereHas('products', function($q) {
                $q->where('status', 'approved');
            })->get();

        $filterSizes = Size::whereHas('products', function($q) {
                $q->where('status', 'approved');
            })->get();

        $brand = null;
        if ($brand_id) {
            $brand = Brand::find($brand_id);
        }

        $seller = null;
        if ($seller_id) {
            $seller = \App\Models\Seller::find($seller_id);
        }

        return view('user.search', compact(
            'products',
            'brand',
            'seller',
            'search',
            'filterBrands',
            'filterColors',
            'filterSizes',
            'filterCollections'
        ));
    }
}