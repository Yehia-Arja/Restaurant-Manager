<?php
<<<<<<< HEAD

=======
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD

class Review extends Model
{
    /** @use HasFactory<\Database\Factories\ReviewFactory> */
    use HasFactory;
=======
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Review extends Model
{
	use HasFactory;

    protected $fillable = [
      'user_id', 'reviewable_id', 'reviewable_type', 'rating', 'comment'
    ];

    public function reviewable(): MorphTo
    {
        return $this->morphTo();
    }
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
}
