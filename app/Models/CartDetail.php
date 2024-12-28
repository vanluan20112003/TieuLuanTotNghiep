<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CartDetail extends Model
{
    use HasFactory;

    protected $fillable = ['cart_id', 'product_id', 'quantity', 'price', 'total_amount'];

    // Định nghĩa quan hệ với Cart
    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    // Định nghĩa quan hệ với Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Tính toán tổng số tiền cho sản phẩm
    public function calculateTotalAmount()
    {
        $this->total_amount = $this->quantity * $this->price;
        $this->save();
    }
}
