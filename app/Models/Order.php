<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'created_at',
        'notes',
        'total_amount',
        'status',
        'payment_method',
        'is_deleted',
        'discount_used',
        'shipping_id'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }
    public function shipping()
{
    return $this->belongsTo(Shipping::class, 'shipping_id');
}
}
