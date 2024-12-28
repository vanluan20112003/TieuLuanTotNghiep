<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogAdmins extends Model
{
    use HasFactory;

    // Tên bảng
    protected $table = 'log_admins';

    // Các cột có thể được gán giá trị (Mass Assignment)
    protected $fillable = [
        'action',
        'action_content',
        'admin_id',
    ];

    // Quan hệ với bảng Users
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id', 'id');
    }
}
