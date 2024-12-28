<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'category_id', 'posted_date', 'price', 'quantity_in_stock',
        'original_price', 'discount', 'description','image','created_at','quantity_sold','purchase_price','is_deleted'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function comments()
{
    return $this->hasMany(CommentProduct::class);
}
public function productIngredients()
{
    return $this->hasMany(ProductIngredient::class);
}

public function ingredients()
{
    return $this->belongsToMany(Ingredient::class, 'product_ingredients')
                ->withPivot('quantity') // Lấy thông tin về lượng nguyên liệu
                ->withTimestamps();
}

}
