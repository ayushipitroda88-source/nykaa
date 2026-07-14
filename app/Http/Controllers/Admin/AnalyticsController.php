<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Seller;
use App\Models\Category;

class AnalyticsController extends Controller
{
    public function products(Request $request)
    {
        $query = Product::with(['brand', 'seller', 'category']);

        $cartSubquery = DB::table('cart_items')
            ->selectRaw('count(distinct user_id)')
            ->whereColumn('product_id', 'products.id');

        $wishlistSubquery = DB::table('wishlists')
            ->selectRaw('count(distinct user_id)')
            ->whereColumn('product_id', 'products.id');

        if ($request->filled('date_from')) {
            $cartSubquery->whereDate('created_at', '>=', $request->date_from);
            $wishlistSubquery->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $cartSubquery->whereDate('created_at', '<=', $request->date_to);
            $wishlistSubquery->whereDate('created_at', '<=', $request->date_to);
        }

        $query->addSelect([
            'cart_users_count' => $cartSubquery,
            'wishlist_users_count' => $wishlistSubquery
        ]);

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('brand_id')) {
            $query->where('brand_id', $request->brand_id);
        }
        if ($request->filled('seller_id')) {
            $query->where('seller_id', $request->seller_id);
        }
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->paginate(15)->withQueryString();
        
        $brands = Brand::all();
        $sellers = Seller::all();
        $categories = Category::all();

        return view('admin.analytics.products', compact('products', 'brands', 'sellers', 'categories'));
    }

    public function brands(Request $request)
    {
        $query = Brand::withCount('products');

        $cartSubquery = DB::table('cart_items')
            ->join('products', 'cart_items.product_id', '=', 'products.id')
            ->selectRaw('count(distinct cart_items.user_id)')
            ->whereColumn('products.brand_id', 'brands.id');

        $wishlistSubquery = DB::table('wishlists')
            ->join('products', 'wishlists.product_id', '=', 'products.id')
            ->selectRaw('count(distinct wishlists.user_id)')
            ->whereColumn('products.brand_id', 'brands.id');

        $query->addSelect([
            'cart_users_count' => $cartSubquery,
            'wishlist_users_count' => $wishlistSubquery
        ]);

        $brands = $query->paginate(15)->withQueryString();

        return view('admin.analytics.brands', compact('brands'));
    }

    public function sellers(Request $request)
    {
        $query = Seller::withCount('products');

        $cartSubquery = DB::table('cart_items')
            ->join('products', 'cart_items.product_id', '=', 'products.id')
            ->selectRaw('count(distinct cart_items.user_id)')
            ->whereColumn('products.seller_id', 'sellers.id');

        $wishlistSubquery = DB::table('wishlists')
            ->join('products', 'wishlists.product_id', '=', 'products.id')
            ->selectRaw('count(distinct wishlists.user_id)')
            ->whereColumn('products.seller_id', 'sellers.id');

        $query->addSelect([
            'cart_users_count' => $cartSubquery,
            'wishlist_users_count' => $wishlistSubquery
        ]);

        $sellers = $query->paginate(15)->withQueryString();

        return view('admin.analytics.sellers', compact('sellers'));
    }
}
