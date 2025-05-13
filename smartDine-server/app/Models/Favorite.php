<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    /** @use HasFactory<\Database\Factories\FavoriteFactory> */
    use HasFactory;
<<<<<<< HEAD
=======

    protected $fillable = [
        'user_id',
        'favoritable_id',
        'favoritable_type',
    ];

    public function favoritable()
    {
        return $this->morphTo();
    }
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
}
