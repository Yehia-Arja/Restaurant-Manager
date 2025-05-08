<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use SoftDeletes;

    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;

     protected $fillable = [
        'product_id','table_id','restaurant_location_id','status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function product()  
    { 
        return $this->belongsTo(Product::class); 
    }
    public function table() 
    { 
        return $this->belongsTo(Table::class); 
    }
    public function location() 
    {
        return $this->belongsTo(RestaurantLocation::class,'restaurant_location_id');
    }
}
