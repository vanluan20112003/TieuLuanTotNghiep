<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'cover_image',
        'content',
        'type',
        'is_deleted',
        'views',
    ];
    public function comments()
    {
        return $this->hasMany(PostComment::class, 'post_id');
    }

    // Nếu cần thêm các phương thức quan hệ, có thể định nghĩa ở đây
}
