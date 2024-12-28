<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogUsers extends Model
{
    use HasFactory;

    // Tên bảng
    protected $table = 'log_users';

    // Cột có thể được gán giá trị hàng loạt (mass assignable)
    protected $fillable = [
        'action',
        'action_content',
        'admin_id',
    ];

    // Cột có kiểu dữ liệu ngày tháng
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    // Thiết lập quan hệ với bảng Users (nếu cần)
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
