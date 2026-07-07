<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $cart = Auth::check()
            ? CartItem::with('product')->where('user_id', Auth::id())->get()->map(function ($item) {
                return [
                    'id' => $item->product->id,
                    'title' => $item->product->title,
                    'price' => $item->price, // 🔥 FIXED: Product price ki jagah CartItem ki saved price (discounted) uthayen
                    'image' => $item->product->image,
                    'quantity' => $item->quantity,
                ];
            })->values()->all()
            : session()->get('cart', []); // 🔥 OPTIMIZED: Guest users ke liye session cart fetch karein index par bhi

        return view('user.cart', compact('cart'));
    }

    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $collectionId = $request->collection_id;

        // Aapka custom model method jo discount calculate karta hai
        $price = $product->getDiscountedPrice($collectionId);

        if (Auth::check()) {
            $item = CartItem::firstOrNew([
                'user_id' => Auth::id(),
                'product_id' => $product->id,
                'collection_id' => $collectionId,
            ]);

            $item->price = $price;
            $item->quantity = ($item->exists ? $item->quantity : 0) + 1;
            $item->save();
        } else {
            $cart = session()->get('cart', []);

            if (isset($cart[$id])) {
                $cart[$id]['quantity']++;
                // Agar session me dubara add ho aur collection_id badle toh price update ho jaye
                $cart[$id]['price'] = $price; 
                $cart[$id]['collection_id'] = $collectionId;
            } else {
                $cart[$id] = [
                    'id' => $product->id,
                    'title' => $product->title,
                    'price' => $price, // 🔥 FIXED: Original price ki jagah calculated $price use karein
                    'collection_id' => $collectionId,
                    'image' => $product->image,
                    'quantity' => 1,
                ];
            }

            session()->put('cart', $cart);
        }

        return back();
    }

    public function increase($id)
    {
        if (Auth::check()) {
            $item = CartItem::where('user_id', Auth::id())->where('product_id', $id)->first();

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
            $item = CartItem::where('user_id', Auth::id())->where('product_id', $id)->first();

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
            CartItem::where('user_id', Auth::id())->where('product_id', $id)->delete();
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