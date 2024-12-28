<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;

    // Đặt tên bảng nếu khác với quy tắc mặc định
    protected $table = 'shipping';

    // Các thuộc tính có thể gán
    protected $fillable = [
        'room_name',
        'floor',
        'building',
        'shipping_fee',
        'status',
    ];

    // Nếu bạn cần định nghĩa các mối quan hệ, thêm ở đây
    // Ví dụ: public function orders() { return $this->hasMany(Order::class); }
}
