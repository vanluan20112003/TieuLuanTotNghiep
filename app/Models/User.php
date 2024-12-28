<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name','user_name','ma_benh_nhan','gioi_tinh','ngay_sinh' ,'email', 'password', 'phone_number', 'avatar', 'address', 'is_admin', 
        'role', 'special_offer', 'is_block','loyalty_points'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_block' => 'boolean',    // Ép kiểu boolean cho is_block
        'special_offer' => 'integer', // Ép kiểu integer cho special_offer
    ];

    // Phương thức kiểm tra xem người dùng có phải là admin không
 
    public function cart()
{
    return $this->hasOne(Cart::class);
}
public function orders()
{
    return $this->hasMany(Order::class);
}
public function isAdmin()
{
    return $this->is_admin === 1; // Kiểm tra xem người dùng có phải là admin hay không
}
}
