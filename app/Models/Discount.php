<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class discount extends Model
{
    use HasFactory;

    protected $table = 'discounts';

    protected $fillable = [
        'name',
        'type', // 'purchase discount', 'special discount', 'event discount'
        'minimum_condition',
        'maximum_condition',
        'created_at',
        'updated_at',
        'duration',
        'discount_amount',
        'description',
        'status', 
        'condition_use',// true/false (default true)
    ];

    // Hàm lấy các mã giảm giá liên quan đến discount này
    public function discountCodes()
    {
        return $this->hasMany(DiscountCode::class, 'discount_id', 'id');
    }
}
