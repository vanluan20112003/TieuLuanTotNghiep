<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostComment extends Model
{
    use HasFactory;

    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'post_comments';

    // Các trường có thể điền dữ liệu
    protected $fillable = [
        'post_id',
        'user_id',
        'content',
    ];

    // Quan hệ với bảng 'posts' (một bình luận thuộc về một bài viết)
    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    // Quan hệ với bảng 'users' (một bình luận thuộc về một người dùng)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
