<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    // Đặt tên bảng
    protected $table = 'reports';

    // Các trường có thể điền dữ liệu
    protected $fillable = [
        'user_id', 
        'report_type', 
        'content', 
        'reportable_id', 
        'admin_check'
    ];

    // Quan hệ với User (người dùng tạo báo cáo)
    public function user()
    {
        return $this->belongsTo(User::class);  // Liên kết với bảng users
    }

    // Quan hệ với đối tượng có thể báo cáo (order hoặc comment)
    public function reportable()
    {
        return $this->morphTo();  // Sử dụng morphTo để hỗ trợ quan hệ đa hình (polymorphic)
    }
}
