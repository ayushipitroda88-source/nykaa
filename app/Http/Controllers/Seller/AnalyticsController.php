<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Category;

class AnalyticsController extends Controller
{
    public function products(Request $request)
    {
        $sellerId = Auth::guard('seller')->id();

        $query = Product::with(['brand', 'category'])
            ->where('seller_id', $sellerId);

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
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->paginate(15)->withQueryString();
        
        $categories = Category::all();

        return view('seller.analytics.products', compact('products', 'categories'));
    }
}
