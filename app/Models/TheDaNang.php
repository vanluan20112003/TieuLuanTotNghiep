<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TheDaNang extends Model
{
    use HasFactory;

    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'the_da_nang';

    // Các cột có thể được điền giá trị
    protected $fillable = [
        'user_id',
        'qr_code',
        'so_du',
        'pp_thanh_toan_1',
        'ma_the_1',
        'pp_thanh_toan_2',
        'ma_the_2',
        'pin_code'
    ];

    // Quan hệ với bảng users, thẻ thuộc về người dùng
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Phương thức format số dư để hiển thị dưới dạng tiền tệ
    public function getFormattedBalanceAttribute()
    {
        return number_format($this->so_du, 0, ',', '.').' VND';
    }

    // Tạo mã QR code ngẫu nhiên khi mở thẻ
    public static function generateQrCode()
    {
        return \Illuminate\Support\Str::random(8);
    }
    
}
