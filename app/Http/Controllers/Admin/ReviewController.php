<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\ReviewReport;
use App\Services\RatingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class ReviewController extends Controller
{
    protected RatingService $ratingService;

    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    /**
     * Display pending reviews list.
     */
    public function pending()
    {
        $reviews = Review::with(['product.seller', 'user', 'images'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $type = 'pending';
        return view('admin.reviews.index', compact('reviews', 'type'));
    }

    /**
     * Display approved reviews list.
     */
    public function approved()
    {
        $reviews = Review::with(['product.seller', 'user', 'images', 'reply'])
            ->where('status', 'approved')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $type = 'approved';
        return view('admin.reviews.index', compact('reviews', 'type'));
    }

    /**
     * Display rejected reviews list.
     */
    public function rejected()
    {
        $reviews = Review::with(['product.seller', 'user', 'images'])
            ->where('status', 'rejected')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $type = 'rejected';
        return view('admin.reviews.index', compact('reviews', 'type'));
    }

    /**
     * Display reported reviews list.
     */
    public function reported()
    {
        $reports = ReviewReport::with(['review.product.seller', 'review.user', 'review.images', 'user'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $type = 'reported';
        return view('admin.reviews.index', compact('reports', 'type'));
    }

    /**
     * Approve a review.
     */
    public function approve($id)
    {
        $review = Review::findOrFail($id);
        $review->status = 'approved';
        $review->rejection_reason = null;
        $review->save();

        $this->ratingService->recalculateProductRating($review->product_id);

        return redirect()->back()->with('success', 'Review approved successfully.');
    }

    /**
     * Reject a review with reason.
     */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000',
        ]);

        $review = Review::findOrFail($id);
        $review->status = 'rejected';
        $review->rejection_reason = $request->rejection_reason;
        $review->save();

        $this->ratingService->recalculateProductRating($review->product_id);

        return redirect()->back()->with('success', 'Review rejected.');
    }

    /**
     * Delete a review.
     */
    public function destroy($id)
    {
        $review = Review::with('images')->findOrFail($id);
        $productId = $review->product_id;

        DB::beginTransaction();
        try {
            foreach ($review->images as $img) {
                $path = public_path('uploads/' . $img->image_path);
                if (File::exists($path)) {
                    File::delete($path);
                }
            }
            $review->delete();
            DB::commit();

            $this->ratingService->recalculateProductRating($productId);

            return redirect()->back()->with('success', 'Review deleted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to delete review: ' . $e->getMessage());
        }
    }

    /**
     * Dismiss a reported review flag.
     */
    public function dismissReport($id)
    {
        $report = ReviewReport::findOrFail($id);
        $report->status = 'dismissed';
        $report->save();

        return redirect()->back()->with('success', 'Report dismissed.');
    }
}
