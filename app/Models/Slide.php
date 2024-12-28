<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use HasFactory;

    /**
     * Tên bảng trong cơ sở dữ liệu.
     */
    protected $table = 'slide';

    /**
     * Các thuộc tính có thể được gán giá trị hàng loạt.
     */
    protected $fillable = [
        'image',
        'content_1',
        'content_2',
        'content_3',
        'status',
    ];

    /**
     * Các thuộc tính cần được định dạng kiểu ngày/thời gian.
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Các giá trị mặc định cho các cột.
     */
    protected $attributes = [
        'status' => 1, // Mặc định là Active
    ];
}
