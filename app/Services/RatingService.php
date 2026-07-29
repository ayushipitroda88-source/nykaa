<?php

namespace App\Services;

use App\Models\Product;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

class RatingService
{
    /**
     * Recalculate and update the average rating and review count for a product.
     *
     * @param int $productId
     * @return Product
     */
    public function recalculateProductRating(int $productId): Product
    {
        $stats = Review::where('product_id', $productId)
            ->where('status', 'approved')
            ->select(
                DB::raw('COUNT(*) as total_reviews'),
                DB::raw('COALESCE(AVG(rating), 0) as average_rating')
            )
            ->first();

        $product = Product::findOrFail($productId);
        $product->average_rating = round((float) $stats->average_rating, 2);
        $product->total_reviews = (int) $stats->total_reviews;
        $product->save();

        return $product;
    }

    /**
     * Get detailed rating breakdown for a product.
     *
     * @param int $productId
     * @return array
     */
    public function getRatingBreakdown(int $productId): array
    {
        $rawCounts = Review::where('product_id', $productId)
            ->where('status', 'approved')
            ->select('rating', DB::raw('COUNT(*) as count'))
            ->groupBy('rating')
            ->pluck('count', 'rating')
            ->toArray();

        $totalReviews = array_sum($rawCounts);
        $breakdown = [];

        for ($star = 5; $star >= 1; $star--) {
            $count = $rawCounts[$star] ?? 0;
            $percentage = $totalReviews > 0 ? round(($count / $totalReviews) * 100, 1) : 0;

            $breakdown[$star] = [
                'count' => $count,
                'percentage' => $percentage,
            ];
        }

        return [
            'total' => $totalReviews,
            'breakdown' => $breakdown,
        ];
    }
}
