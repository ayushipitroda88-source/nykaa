<?php

namespace App\Http\Controllers;
use App\Models\Collection;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Size;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = Collection::all();
        return view('collections.index', compact('collections'));
    }
        
    public function store(Request $request)
    {
        $imageName = null;

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/collections'), $imageName);
        }

        $collection = Collection::create([
            'name'             => $request->name,
            'slug'             => Str::slug($request->name),
            'description'      => $request->description,
            'image'            => $imageName,
            'status'           => $request->status ?? 1,
            'discount'         => $request->discount,
            'discount_start'   => $request->discount_start,
            'discount_end'     => $request->discount_end,
        ]);

        $collection->products()->attach($request->products ?? []);

        return redirect()
                ->route('collections.index')
                ->with('success', 'Collection Created Successfully');
    }
       
    public function update(Request $request, $id)
    {
        $collection = Collection::findOrFail($id);

        $data = [
            'name'             => $request->name,
            'discount'         => $request->discount,
            'discount_start'   => $request->discount_start,
            'discount_end'     => $request->discount_end,
        ];

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/collections'), $imageName);
            $data['image'] = $imageName;
        }

        $collection->update($data);
        return redirect()->back()->with('success', 'Collection Updated Successfully');
    }
    
    public function destroy(Collection $collection)
    {
        $collection->delete();
        return redirect()->back()->with('success', 'Collection deleted successfully');
    }

    public function userIndex()
    {
        $collections = Collection::where('status', 1)->latest()->get();
        return view('user.collections', compact('collections'));
    }

    public function userShow($id, Request $request)
    {
        $collection = Collection::findOrFail($id);

        // Base query
        $query = $collection->products()->where('status', 'approved');

        // Sort
        $sort = $request->sort ?? 'newest';
        switch ($sort) {
            case 'price_asc': $query->orderBy('price', 'asc'); break;
            case 'price_desc': $query->orderBy('price', 'desc'); break;
            case 'name_asc': $query->orderBy('title', 'asc'); break;
            case 'name_desc': $query->orderBy('title', 'desc'); break;
            default: $query->latest(); break;
        }

        // Brand filter
        if ($request->filled('brand')) {
            $query->where('brand_id', $request->brand);
        }

        // Category filter
        if ($request->filled('category')) {
            $catIds = collect([$request->category]);
            $cat = Category::with('children.children')->find($request->category);
            if ($cat) {
                foreach ($cat->children as $child) {
                    $catIds->push($child->id);
                    foreach ($child->children as $sub) {
                        $catIds->push($sub->id);
                    }
                }
            }
            $query->whereIn('category_id', $catIds);
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

        // Discount filter
        if ($request->filled('discount')) {
            $discount = $request->discount;
            $query->whereHas('collections', function ($q) use ($discount) {
                $q->where('discount', '>=', $discount)
                  ->where('status', 1)
                  ->where('discount_start', '<=', now())
                  ->where('discount_end', '>=', now());
            });
        }

        $query->with(['category', 'collections', 'brand', 'colors', 'sizes', 'variants.color']);
        $products = $query->paginate(12)->withQueryString();

        // Filter data
        $filterBrands = Brand::whereHas('products', function ($q) {
            $q->where('status', 'approved');
        })->withCount(['products' => function ($q) {
            $q->where('status', 'approved');
        }])->get();

        $filterColors = Color::whereHas('products', function ($q) {
            $q->where('status', 'approved');
        })->get();

        $filterSizes = Size::whereHas('products', function ($q) {
            $q->where('status', 'approved');
        })->get();

        $filterCollections = Collection::where('status', 1)
            ->whereHas('products', function ($q) {
                $q->where('status', 'approved');
            })->get();

        return view('user.collection-products', compact(
            'collection',
            'products',
            'filterBrands',
            'filterColors',
            'filterSizes',
            'filterCollections'
        ));
    }
}