<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $sellerId = Auth::guard('seller')->id();

        $totalProducts = Product::where('seller_id', $sellerId)->count();
        
        // Product status counts for approval workflow
        $pendingProducts = Product::where('seller_id', $sellerId)->where('status', 'pending')->count();
        $approvedProducts = Product::where('seller_id', $sellerId)->where('status', 'approved')->count();
        $rejectedProducts = Product::where('seller_id', $sellerId)->where('status', 'rejected')->count();
        $resubmittedProducts = Product::where('seller_id', $sellerId)->where('status', 'resubmitted')->count();

        $pendingOrders = OrderItem::where('seller_id', $sellerId)
            ->whereHas('order', function ($query) {
                $query->where('status', 'pending');
            })->count();

        $completedOrders = OrderItem::where('seller_id', $sellerId)
            ->whereHas('order', function ($query) {
                $query->where('status', 'completed');
            })->count();

        $todaysRevenue = OrderItem::where('seller_id', $sellerId)
            ->whereHas('order', function ($query) {
                $query->whereDate('created_at', today());
            })->sum('price');

        $monthlyRevenue = OrderItem::where('seller_id', $sellerId)
            ->whereHas('order', function ($query) {
                $query->whereMonth('created_at', date('m'))
                      ->whereYear('created_at', date('Y'));
            })->sum('price');

        $cartActivity = DB::table('cart_items')
            ->join('products', 'cart_items.product_id', '=', 'products.id')
            ->where('products.seller_id', $sellerId)
            ->select('cart_items.product_id', 'cart_items.user_id')
            ->distinct()
            ->get()
            ->count();

        $wishlistActivity = DB::table('wishlists')
            ->join('products', 'wishlists.product_id', '=', 'products.id')
            ->where('products.seller_id', $sellerId)
            ->select('wishlists.product_id', 'wishlists.user_id')
            ->distinct()
            ->get()
            ->count();

        $mostPopularProduct = Product::where('seller_id', $sellerId)
            ->addSelect([
                'cart_users_count' => DB::table('cart_items')
                    ->selectRaw('count(distinct user_id)')
                    ->whereColumn('product_id', 'products.id')
            ])
            ->orderByDesc('cart_users_count')
            ->first();

        return view('seller.dashboard', compact(
            'totalProducts',
            'pendingProducts',
            'approvedProducts',
            'rejectedProducts',
            'resubmittedProducts',
            'pendingOrders',
            'completedOrders',
            'todaysRevenue',
            'monthlyRevenue',
            'cartActivity',
            'wishlistActivity',
            'mostPopularProduct'
        ));
    }
}
