<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use HasFactory;

    protected $table = 'ingredients'; // Đảm bảo rằng tên bảng là 'ingredients'

    protected $fillable = [
        'name', 
        'unit', 
        'status',
    ];

    // Quan hệ với bảng `product_ingredients`
    public function productIngredients()
    {
        return $this->hasMany(ProductIngredient::class);
    }
}
