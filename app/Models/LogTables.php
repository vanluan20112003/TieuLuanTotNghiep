<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogTables extends Model
{
    use HasFactory;

    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'log_tables';

    // Các trường có thể điền dữ liệu (Mass assignment)
    protected $fillable = [
        'action',
        'action_content',
        'admin_id',
    ];

    // Nếu bảng có timestamps
    public $timestamps = true;

    // Quan hệ với bảng User (admin)
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
