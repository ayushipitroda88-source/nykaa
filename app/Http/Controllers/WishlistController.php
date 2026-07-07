<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    // Wishlist Page
    public function index()
    {
        $wishlists = Wishlist::with(['product', 'collection'])
                    ->where('user_id', Auth::id())
                    ->latest()
                    ->get();

        return view('user.wishlist', compact('wishlists'));
    }

    // Add To Wishlist
    public function add($id)
    {
        $product = Product::findOrFail($id);
        $collectionId = request()->input('collection_id');

        $exists = Wishlist::where('user_id', Auth::id())
                    ->where('product_id', $product->id)
                    ->where('collection_id', $collectionId)
                    ->exists();

        if (!$exists) {

            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'collection_id' => $collectionId,
            ]);

        }

        return back()->with('success','Product added to wishlist.');
    }

    // Remove Wishlist
    public function remove($id)
    {
        Wishlist::where('user_id',Auth::id())
                ->where('product_id',$id)
                ->delete();

        return back()->with('success','Product removed.');
    }

    // Wishlist -> Add To Cart
    public function addToCart($id)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
                        ->where('product_id', $id)
                        ->firstOrFail();

        $product = Product::findOrFail($id);
        $collectionId = $wishlist->collection_id;
        $price = $product->getDiscountedPrice($collectionId);

        $cart = CartItem::firstOrNew([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'collection_id' => $collectionId,
        ]);

        $cart->price = $price;
        $cart->quantity = ($cart->exists ? $cart->quantity : 0) + 1;
        $cart->save();

        return back()->with('success', 'Product added to cart.');
    }
}