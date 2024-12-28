<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodSuggestion extends Model
{
    use HasFactory;

    // Các cột có thể gán đại diện
    protected $fillable = [
        'product_id',
        'department_suggestion',
        'disease_suggestion',
        'flavor',
        'benefits',
        'meal_time',
    ];

    // Quan hệ với bảng Product (FoodSuggestion thuộc về 1 Product)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
