<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Client\CreateReviewRequest;
use App\Services\Client\ReviewService;
use App\Http\Resources\Common\ReviewResource;

class ReviewController extends Controller
{
    public function store(CreateReviewRequest $request)
    {
        try {
            $data = $request->validated();
            $data['user_id'] = Auth::id();

            $review = ReviewService::createReview($data);

            return $this->success('Review submitted', $review);
        } catch (\Throwable $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}