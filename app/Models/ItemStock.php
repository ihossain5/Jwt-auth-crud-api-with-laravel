<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemStock extends Model {
    use HasFactory;
    protected $fillable = ['food_item_id', 'quantity'];
    protected $hidden   = ['created_at', 'updated_at'];

}
