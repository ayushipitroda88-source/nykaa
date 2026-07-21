<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Wishlist;
use App\Models\CartItem;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('user.*', function ($view) {

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

            $view->with('categories', $categories);

            // Share wishlist product IDs for pink heart on product cards
            if (Auth::check()) {
                $wishlistProductIds = Wishlist::where('user_id', Auth::id())
                    ->pluck('product_id')
                    ->toArray();
            } else {
                $wishlistProductIds = [];
            }

            $view->with('wishlistProductIds', $wishlistProductIds);

            // Cart count
            $cartCount = 0;
            if (Auth::check()) {
                $cartCount = CartItem::where('user_id', Auth::id())->sum('quantity');
            } else {
                $cart = session('cart', []);
                $cartCount = array_sum(array_column($cart, 'quantity'));
            }

            $view->with('cartCount', $cartCount);

        });
    }
}
