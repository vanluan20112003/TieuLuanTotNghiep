<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BanAn extends Model
{
    use HasFactory;

    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'ban_an';

    // Các trường có thể điền dữ liệu
    protected $fillable = [
        'ten_ban',
        'status',
    ];

    // Nếu bảng không có timestamps (created_at, updated_at), hãy bỏ dòng này
    public $timestamps = false;
    public function datBans()
    {
        return $this->hasMany(DatBan::class, 'ban_an_id');
    }
}
