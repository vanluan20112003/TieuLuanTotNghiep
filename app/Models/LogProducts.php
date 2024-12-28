<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogProducts extends Model
{
    use HasFactory;

    protected $table = 'Log_Products';  // Tên bảng
    protected $primaryKey = 'id';       // Khóa chính
    public $timestamps = false;         // Tắt auto timestamps, vì đã có cột created_at và updated_at tùy chỉnh

    protected $fillable = [
        'product_id',
        'action',
        'action_content',
        'admin_id',
        'created_at',
        'updated_at',
    ];

    // Quan hệ với bảng products
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Quan hệ với bảng users
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}
