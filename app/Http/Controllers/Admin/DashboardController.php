<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Seller;

class DashboardController extends Controller
{
    public function index()
    {
        // Total Cart Activity (sum of unique users per product)
        $totalCartActivity = DB::table('cart_items')
            ->select('product_id', 'user_id')
            ->distinct()
            ->get()
            ->count();

        // Total Wishlist Activity (sum of unique users per product)
        $totalWishlistActivity = DB::table('wishlists')
            ->select('product_id', 'user_id')
            ->distinct()
            ->get()
            ->count();

        $mostAddedProduct = Product::addSelect([
                'cart_users_count' => DB::table('cart_items')
                    ->selectRaw('count(distinct user_id)')
                    ->whereColumn('product_id', 'products.id')
            ])
            ->orderByDesc('cart_users_count')
            ->first();

        // Most Popular Brand
        $mostPopularBrand = Brand::withCount(['products as cart_users_count' => function ($query) {
            $query->join('cart_items', 'products.id', '=', 'cart_items.product_id')
                  ->select(DB::raw('count(distinct cart_items.user_id)'));
        }])->orderByDesc('cart_users_count')->first();

        // Most Active Seller
        $mostActiveSeller = Seller::withCount(['products as cart_users_count' => function ($query) {
            $query->join('cart_items', 'products.id', '=', 'cart_items.product_id')
                  ->select(DB::raw('count(distinct cart_items.user_id)'));
        }])->orderByDesc('cart_users_count')->first();

        return view('admin.dashboard', compact(
            'totalCartActivity',
            'totalWishlistActivity',
            'mostAddedProduct',
            'mostPopularBrand',
            'mostActiveSeller'
        ));
    }
}
