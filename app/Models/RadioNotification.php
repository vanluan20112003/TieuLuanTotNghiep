<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadioNotification extends Model
{
    use HasFactory;

    // Định nghĩa tên bảng (nếu không theo quy tắc mặc định của Laravel)
    protected $table = 'radio_notifications';

    // Định nghĩa các cột có thể mass assign
    protected $fillable = [
        'level', 
        'content', 
        'expiration_period', 
        'created_at',
        'updated_at'
    ];

    // Định nghĩa các cột mà Laravel sẽ tự động quản lý thời gian (created_at, updated_at)
    public $timestamps = true;
}
