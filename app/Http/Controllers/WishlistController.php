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
        $wishlists = Wishlist::with(['product', 'collection', 'variant.color', 'variant.size'])
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
        $variantId = request()->input('variant_id');

        $exists = Wishlist::where('user_id', Auth::id())
                    ->where('product_id', $product->id)
                    ->where('variant_id', $variantId)
                    ->where('collection_id', $collectionId)
                    ->exists();

        if (!$exists) {

            Wishlist::create([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'variant_id' => $variantId,
                'collection_id' => $collectionId,
            ]);

        }

        return back()->with('success','Product added to wishlist.');
    }

    // Remove Wishlist
    public function remove($id)
    {
        // $id is now wishlist item id
        Wishlist::where('user_id',Auth::id())
                ->where('id',$id)
                ->delete();

        return back()->with('success','Product removed.');
    }

    // Wishlist -> Add To Cart
    public function addToCart($id)
    {
        $wishlist = Wishlist::where('user_id', Auth::id())
                        ->where('id', $id)
                        ->firstOrFail();

        $product = Product::findOrFail($wishlist->product_id);
        $collectionId = $wishlist->collection_id;
        $variant = \App\Models\ProductVariant::find($wishlist->variant_id);
        $price = $variant ? $variant->price : $product->getDiscountedPrice($collectionId);

        $cart = CartItem::firstOrNew([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'variant_id' => $wishlist->variant_id,
            'collection_id' => $collectionId,
        ]);

        $cart->price = $price;
        $cart->quantity = ($cart->exists ? $cart->quantity : 0) + 1;
        $cart->save();
        $wishlist->delete();
        return back()->with('success', 'Product added to cart.');

            
    }
}