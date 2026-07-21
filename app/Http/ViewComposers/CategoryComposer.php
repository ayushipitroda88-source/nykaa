<?php

namespace App\Http\ViewComposers;

use App\Models\Category;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use App\Models\CartItem;
use Illuminate\View\View;

class CategoryComposer
{
    /**
     * Bind data to the view.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        // Categories for mega menu (3 levels deep)
        $categories = Category::whereNull('parent_id')
            ->where('status', 1)
            ->with(['children' => function ($q) {
                $q->where('status', 1)->orderBy('position');
            }, 'children.children' => function ($q) {
                $q->where('status', 1)->orderBy('position');
            }])
            ->orderBy('position')
            ->get();

        // Wishlist product IDs
        $wishlistProductIds = [];
        if (Auth::check()) {
            $wishlistProductIds = Wishlist::where('user_id', Auth::id())
                ->pluck('product_id')
                ->toArray();
        }

        // Cart count
        $cartCount = 0;
        if (Auth::check()) {
            $cartCount = CartItem::where('user_id', Auth::id())->sum('quantity');
        } else {
            $cart = session('cart', []);
            $cartCount = array_sum(array_column($cart, 'quantity'));
        }

        $view->with(compact('categories', 'wishlistProductIds', 'cartCount'));
    }
}