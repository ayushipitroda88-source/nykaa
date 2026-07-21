<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\VariantSize;

class CartController extends Controller
{
   public function index()
{
    $cart = Auth::check()
        ? CartItem::with([
                'product',
                'variant.variant.color',
                'variant.size'
            ])
            ->where('user_id', Auth::id())
            ->get()
            ->map(function ($item) {
                return [
                    'id'            => $item->id, // Cart item primary key
                    'product_id'    => $item->product->id,
                    'variant_id'    => $item->variant_id,
                    'title'         => $item->product->title,
                    'price'         => $item->price,
                    'variant_image' => $item->variant?->variant?->image,
                    'product_image' => $item->product->image,
                    'color'         => $item->variant?->variant?->color?->name,
                    'size'          => $item->variant?->size?->name,
                    'quantity'      => $item->quantity,
                ];
            })
            ->values()
            ->all()
        : array_values(session()->get('cart', []));

    return view('user.cart', compact('cart'));
}
    public function add(Request $request, $id)
{
    // Only allow adding approved products to cart
    $product = Product::where('status', 'approved')->findOrFail($id);

    $variant = VariantSize::with(['variant.product', 'variant.color', 'size'])
                ->findOrFail($request->variant_id);

    $collectionId = $request->collection_id;

    $price = $variant->price;

    if (Auth::check()) {

        $item = CartItem::firstOrNew([

            'user_id' => Auth::id(),

            'product_id' => $product->id,

            'variant_id' => $variant->id,

            'collection_id' => $collectionId,

        ]);

        $item->price = $price;

        $item->quantity = ($item->exists ? $item->quantity : 0) + 1;

        $item->save();

    } else {

        $cart = session()->get('cart', []);

        $key = $variant->id;

        if(isset($cart[$key])){

            $cart[$key]['quantity']++;

        }else{

            $cart[$key] = [

                'id' => $product->id,

                'variant_id' => $variant->id,

                'title' => $product->title,

                'price' => $variant->price,

                'image' => optional($variant->variant)->image,
                'color' => optional(optional($variant->variant)->color)->name,
                'size' => optional($variant->size)->name,
                'quantity' => 1,

            ];

        }

        session()->put('cart',$cart);
    }

    return back()->with('success','Product Added To Cart');
}
   
    public function increase($id)
    {
         
        if (Auth::check()) {
            $item = CartItem::where('user_id', Auth::id())->where('id', $id)->first();

            if ($item) {
                $item->quantity++;
                $item->save();
            }
        } else {
            $cart = session()->get('cart', []);

            if (isset($cart[$id])) {
                $cart[$id]['quantity']++;
            }

            session()->put('cart', $cart);
        }

        return back();
    }

    public function decrease($id)
    {
        if (Auth::check()) {
            $item = CartItem::where('user_id', Auth::id())->where('id', $id)->first();

            if ($item) {
                $item->quantity--;

                if ($item->quantity <= 0) {
                    $item->delete();
                } else {
                    $item->save();
                }
            }
        } else {
            $cart = session()->get('cart', []);

            if (isset($cart[$id])) {
                $cart[$id]['quantity']--;

                if ($cart[$id]['quantity'] <= 0) {
                    unset($cart[$id]);
                }
            }

            session()->put('cart', $cart);
        }

        return back();
    }

    public function remove($id)
    {
        if (Auth::check()) {
            CartItem::where('user_id', Auth::id())->where('id', $id)->delete();
        } else {
            $cart = session()->get('cart', []);
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return back();
    }

    public function checkout()
    {
        $cart = Auth::check()
            ? CartItem::with('product')->where('user_id', Auth::id())->get()->map(function ($item) {
                return [
                    'id' => $item->product->id,
                    'title' => $item->product->title,
                    'price' => $item->price, // Sahi chal raha hai
                    'image' => $item->product->image,
                    'quantity' => $item->quantity,
                ];
            })->values()->all()
            : session()->get('cart', []); // 🔥 FIXED: Checkout par guest cart support setup kiya

        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('user.checkout', compact('cart', 'total'));
    }
}