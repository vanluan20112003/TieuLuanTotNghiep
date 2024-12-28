<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total'];

    // Định nghĩa quan hệ với CartDetail
    public function cartDetails()
    {
        return $this->hasMany(CartDetail::class);
    }

    // Định nghĩa quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Tính tổng số tiền giỏ hàng
    public function calculateTotal()
    {
        $this->total = $this->cartDetails->sum('total_amount');
        $this->save();
    }
}
