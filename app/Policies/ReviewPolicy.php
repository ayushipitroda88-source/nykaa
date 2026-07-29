<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Seller;
use App\Models\Review;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class ReviewPolicy
{
    /**
     * Determine whether the user can write a review for a product.
     */
    public function create(User $user, Product $product): bool
    {
        // Check if user has an order containing this product with status 'delivered'
        return OrderItem::whereHas('order', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->where('status', 'delivered');
        })->where('product_id', $product->id)->exists();
    }

    /**
     * Determine whether the user can update the review.
     */
    public function update(User $user, Review $review): bool
    {
        return (int) $review->user_id === (int) $user->id;
    }

    /**
     * Determine whether a seller can reply to the review.
     */
    public function reply(?Seller $seller, Review $review): bool
    {
        if (!$seller) return false;
        return (int) $review->product->seller_id === (int) $seller->id;
    }
}
