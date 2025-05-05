<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Client\CreateReviewRequest;
use App\Services\Client\ReviewService;
use App\Http\Resources\Common\ReviewResource;

class ReviewController extends Controller
{
    /**
     * POST  /api/v0.1/common/reviews
     *
     * Create a new review for any “reviewable” (product, restaurant, waiter, etc.).
     * Payload must include: reviewable_type, reviewable_id, rating (1–5), optional comment.
     */
    public function store(CreateReviewRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = Auth::id();

        $review = ReviewService::createReview($data);

        return $this->success('Review submitted', $review);
    }
}
