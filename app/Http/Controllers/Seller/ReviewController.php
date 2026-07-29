<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\ReviewReply;
use App\Models\Product;
use App\Http\Requests\ReplyReviewRequest;
use App\Services\RatingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReviewController extends Controller
{
    protected RatingService $ratingService;

    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    /**
     * Display seller product reviews & overview analytics.
     */
    public function index(Request $request)
    {
        $sellerId = Auth::guard('seller')->id();

        // Get seller product IDs
        $sellerProductIds = Product::where('seller_id', $sellerId)->pluck('id');

        // Overview stats for seller's products
        $stats = Review::whereIn('product_id', $sellerProductIds)
            ->where('status', 'approved')
            ->select(
                DB::raw('COUNT(*) as total_reviews'),
                DB::raw('COALESCE(AVG(rating), 0) as average_rating')
            )
            ->first();

        // Rating breakdown for seller's products
        $rawBreakdown = Review::whereIn('product_id', $sellerProductIds)
            ->where('status', 'approved')
            ->select('rating', DB::raw('COUNT(*) as count'))
            ->groupBy('rating')
            ->pluck('count', 'rating')
            ->toArray();

        $totalReviews = (int) $stats->total_reviews;
        $ratingBreakdown = [];
        for ($star = 5; $star >= 1; $star--) {
            $count = $rawBreakdown[$star] ?? 0;
            $ratingBreakdown[$star] = [
                'count' => $count,
                'percentage' => $totalReviews > 0 ? round(($count / $totalReviews) * 100, 1) : 0,
            ];
        }

        // Paginated reviews list with filter option
        $statusFilter = $request->query('status', 'all');

        $reviewsQuery = Review::with(['product', 'user', 'images', 'reply'])
            ->whereIn('product_id', $sellerProductIds);

        if ($statusFilter !== 'all') {
            $reviewsQuery->where('status', $statusFilter);
        }

        $reviews = $reviewsQuery->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        return view('seller.reviews.index', compact(
            'stats',
            'ratingBreakdown',
            'reviews',
            'statusFilter'
        ));
    }

    /**
     * Store or update seller reply to a review.
     */
    public function reply(ReplyReviewRequest $request, $id)
    {
        $sellerId = Auth::guard('seller')->id();

        $review = Review::whereHas('product', function ($q) use ($sellerId) {
            $q->where('seller_id', $sellerId);
        })->findOrFail($id);

        ReviewReply::updateOrCreate(
            ['review_id' => $review->id],
            [
                'seller_id' => $sellerId,
                'reply' => $request->reply,
            ]
        );

        return redirect()->back()->with('success', 'Your reply has been posted successfully.');
    }
}
