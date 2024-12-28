<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserReact extends Model
{
    use HasFactory;

    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'user_react';

    // Các thuộc tính có thể được gán giá trị
    protected $fillable = [
        'user_id',
        'react_comment_product_id',
        'like',
        'dislike',
        'reply',
        'created_at' ,
    ];

    // Quan hệ với model User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Quan hệ với model CommentProduct
    public function commentProduct()
    {
        return $this->belongsTo(CommentProduct::class, 'react_comment_product_id');
    }
}
