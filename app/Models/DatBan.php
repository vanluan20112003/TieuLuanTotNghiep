<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatBan extends Model
{
    use HasFactory;

    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'dat_ban';

    // Các trường có thể điền dữ liệu
    protected $fillable = [
        'ban_an_id',
        'user_id',
        'thoi_gian_dat',
        'thoi_gian_roi',
        'trang_thai',
    ];

    // Nếu bảng không có timestamps (created_at, updated_at), hãy bỏ dòng này
    public $timestamps = false;

    // Liên kết với model BanAn
    public function banAn()
    {
        return $this->belongsTo(BanAn::class, 'ban_an_id');
    }

    // Liên kết với model User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
