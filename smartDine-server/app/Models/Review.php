<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Review extends Model
{
    protected $fillable = [
      'user_id', 'reviewable_id', 'reviewable_type', 'rating', 'comment'
    ];

    public function reviewable(): MorphTo
    {
        return $this->morphTo();
    }
}
