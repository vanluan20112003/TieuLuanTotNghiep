<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductIngredient extends Model
{
    use HasFactory;

    protected $table = 'product_ingredients'; // Đảm bảo rằng tên bảng là 'product_ingredients'

    protected $fillable = [
        'product_id', 
        'ingredient_id', 
        'quantity',
    ];

    // Quan hệ với bảng `ingredient`
    public function ingredient()
    {
        return $this->belongsTo(Ingredient::class);
    }

    // Quan hệ với bảng `product`
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
