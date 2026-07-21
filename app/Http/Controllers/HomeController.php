<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Collection;
use Illuminate\Support\Facades\Auth;
use App\Models\Wishlist;
use App\Models\Brand;
use App\Models\Seller;

class HomeController extends Controller
{
   public function index()
{
    // Root Categories
    $categories = Category::whereNull('parent_id')
                    ->where('status', 1)
                    ->orderBy('position')
                    ->get();
  
$brands = Brand::where('status',1)->get();

// Approved Sellers (shown as "Brands" on user side)
$sellers = Seller::where('status', 'approved')->get();

    // Products
   $products = Product::with([
    'category',
    'collections',
    'variants.color',
    'variants.sizes'
])->where('status', 'approved')->get();
    // Collections
    $collections = Collection::where('status',1)
                    ->latest()
                    ->take(4)
                    ->get();

    // Wishlist Products
    $wishlistItems = [];

    if(Auth::check()){
        $wishlistItems = Wishlist::where('user_id', Auth::id())
                        ->pluck('product_id')
                        ->toArray();
    }

    return view('user.home', compact(
        'categories',
        'products',
        'collections',
          'brands',
          'sellers',
        'wishlistItems'
    ));

    
}

    public function show($slug)
{
    $collection = Collection::where('slug',$slug)->firstOrFail();

    $products = $collection->products()
                    ->where('status',1)
                    ->paginate(12);

    return view('user.collection-show',compact('collection','products'));
}
}