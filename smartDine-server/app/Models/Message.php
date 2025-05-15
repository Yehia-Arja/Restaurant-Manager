<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    /** @use HasFactory<\Database\Factories\MessageFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'chat_id',
        'sender_type',
        'content',
    ];


    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
}
