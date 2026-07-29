<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\ReviewImage;
use App\Models\ReviewHelpful;
use App\Models\ReviewReport;
use App\Models\Product;
use App\Models\OrderItem;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;
use App\Http\Requests\ReportReviewRequest;
use App\Services\RatingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class CustomerReviewController extends Controller
{
    protected RatingService $ratingService;

    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    /**
     * Store a new customer review.
     */
    public function store(StoreReviewRequest $request)
    {
        $userId = Auth::id();
        $productId = $request->product_id;

        // Rule: Must have a confirmed order containing this product
        $confirmedOrderItem = OrderItem::whereHas('order', function ($q) use ($userId) {
            $q->where('user_id', $userId)->where('status', 'confirmed');
        })->where('product_id', $productId)->first();

        if (!$confirmedOrderItem) {
            return redirect()->back()->with('error', 'You can review a product only after confirming your order.');
        }

        // Rule: Only one review per user per product
        $existingReview = Review::where('user_id', $userId)->where('product_id', $productId)->first();
        if ($existingReview) {
            return redirect()->back()->with('error', 'You have already submitted a review for this product. You can edit your existing review.');
        }

        DB::beginTransaction();
        try {
            $review = Review::create([
                'user_id' => $userId,
                'product_id' => $productId,
                'order_id' => $confirmedOrderItem->order_id,
                'order_item_id' => $confirmedOrderItem->id,
                'rating' => $request->rating,
                'title' => $request->title ?? '',
                'description' => $request->description,
                'status' => 'approved', // Auto-approved for immediate visibility
                'is_verified_purchase' => true,
            ]);

            // Handle Review Images (Max 5)
            if ($request->hasFile('images')) {
                $uploadPath = public_path('uploads/reviews');
                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true, true);
                }

                foreach ($request->file('images') as $image) {
                    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move($uploadPath, $filename);

                    ReviewImage::create([
                        'review_id' => $review->id,
                        'image_path' => 'reviews/' . $filename,
                    ]);
                }
            }

            DB::commit();

            // Recalculate ratings
            $this->ratingService->recalculateProductRating($productId);

            return redirect()->back()->with('success', 'Thank you! Your review has been submitted successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to submit review: ' . $e->getMessage());
        }
    }

    /**
     * Update an existing customer review.
     */
    public function update(UpdateReviewRequest $request, $id)
    {
        $review = Review::where('user_id', Auth::id())->findOrFail($id);

        DB::beginTransaction();
        try {
            $review->update([
                'rating' => $request->rating,
                'title' => $request->title ?? '',
                'description' => $request->description,
                'status' => 'approved', // Keep approved after edit
                'rejection_reason' => null,
            ]);

            // Handle image uploads if new images are provided
            if ($request->hasFile('images')) {
                $uploadPath = public_path('uploads/reviews');
                if (!File::exists($uploadPath)) {
                    File::makeDirectory($uploadPath, 0755, true, true);
                }

                // Delete old images if replaced
                foreach ($review->images as $oldImage) {
                    $oldPath = public_path('uploads/' . $oldImage->image_path);
                    if (File::exists($oldPath)) {
                        File::delete($oldPath);
                    }
                    $oldImage->delete();
                }

                foreach ($request->file('images') as $image) {
                    $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move($uploadPath, $filename);

                    ReviewImage::create([
                        'review_id' => $review->id,
                        'image_path' => 'reviews/' . $filename,
                    ]);
                }
            }

            DB::commit();

            $this->ratingService->recalculateProductRating($review->product_id);

            return redirect()->back()->with('success', 'Your review has been updated.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update review: ' . $e->getMessage());
        }
    }

    /**
     * Delete a customer's own review.
     */
    public function destroy($id)
    {
        $review = Review::where('user_id', Auth::id())->findOrFail($id);
        $productId = $review->product_id;

        // Delete review images
        foreach ($review->images as $img) {
            $path = public_path('uploads/' . $img->image_path);
            if (File::exists($path)) {
                File::delete($path);
            }
        }

        $review->delete();

        // Recalculate ratings
        $this->ratingService->recalculateProductRating($productId);

        return redirect()->back()->with('success', 'Your review has been deleted.');
    }

    /**
     * Display customer's submitted reviews in profile.
     */
    public function myReviews()
    {
        $reviews = Review::with(['product', 'images', 'reply.seller'])
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.reviews.index', compact('reviews'));
    }

    /**
     * Toggle helpful vote on a review.
     */
    public function voteHelpful(Request $request, $id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Please login to mark review as helpful.'], 401);
        }

        $userId = Auth::id();
        $review = Review::findOrFail($id);

        $existing = ReviewHelpful::where('review_id', $review->id)
            ->where('user_id', $userId)
            ->first();

        if ($existing) {
            $existing->delete();
            $review->decrement('helpful_count');
            $voted = false;
        } else {
            ReviewHelpful::create([
                'review_id' => $review->id,
                'user_id' => $userId,
            ]);
            $review->increment('helpful_count');
            $voted = true;
        }

        return response()->json([
            'success' => true,
            'voted' => $voted,
            'helpful_count' => $review->fresh()->helpful_count,
        ]);
    }

    /**
     * Report an inappropriate review.
     */
    public function report(ReportReviewRequest $request, $id)
    {
        $userId = Auth::id();
        $review = Review::findOrFail($id);

        $existingReport = ReviewReport::where('review_id', $review->id)
            ->where('user_id', $userId)
            ->first();

        if ($existingReport) {
            return redirect()->back()->with('info', 'You have already reported this review.');
        }

        ReviewReport::create([
            'review_id' => $review->id,
            'user_id' => $userId,
            'reason' => $request->reason,
            'details' => $request->details,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Thank you. The review has been reported to moderators for review.');
    }
}
