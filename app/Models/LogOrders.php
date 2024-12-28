<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogOrders extends Model
{
    use HasFactory;

    protected $table = 'log_orders'; // Tên bảng trong database

    protected $fillable = [
        'action',
        'action_content',
        'admin_id',
    ];

    // Liên kết với admin (người dùng)
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id', 'id');
    }
}
