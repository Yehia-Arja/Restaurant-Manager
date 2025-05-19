<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chair extends Model
{
    /** @use HasFactory<\Database\Factories\ChairFactory> */
    use HasFactory;

    public function sensor()
    {
        return $this->belongsTo(Sensor::class);
    }

    public function table() {
        return $this->belongsTo(Table::class);
    }
}
