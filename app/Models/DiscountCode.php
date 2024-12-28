<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountCode extends Model
{
    use HasFactory;

    protected $table = 'discount_codes';

    protected $fillable = [
        'user_id',
        'discount_id',
        'expiration_date',
        'created_at',
        'updated_at',
        'quantity'
    ];

    // Liên kết với bảng discounts
    public function discount()
    {
        return $this->belongsTo(Discount::class, 'discount_id', 'id');
    }

    // Liên kết với user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
