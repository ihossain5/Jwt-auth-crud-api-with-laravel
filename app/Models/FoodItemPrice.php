<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodItemPrice extends Model {
    use HasFactory;
    protected $fillable = ['food_item_id', 'original_price', 'discounted_price', 'discount_type', 'fixed_value', 'percent_of'];

    protected $hidden = ['created_at', 'updated_at'];
}
