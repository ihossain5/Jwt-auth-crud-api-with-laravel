<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodItemCategory extends Model {
    use HasFactory;

    protected $fillable = ['name', 'image', 'icon'];

    protected $hidden = ['created_at', 'updated_at', 'pivot'];
}
