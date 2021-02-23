<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodItem extends Model {
    use HasFactory;
    protected $fillable = ['name', 'image', 'is_visible', 'is_available'];
    protected $hidden   = ['created_at', 'updated_at'];

    // for pivot table
    public function foodItemCategory() {
        return $this->belongsToMany(FoodItemCategory::class, 'food_items_have_categories', 'food_item_id', 'food_item_category_id')
            ->withTimestamps();
    }
    // for get product price
    public function price() {
        return $this->hasMany(FoodItemPrice::class);
    }
    // for get product quantity
    public function stockItems() {
        return $this->hasMany(ItemStock::class);
    }
}
