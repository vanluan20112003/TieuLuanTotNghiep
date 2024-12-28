<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'content',
        'star_rating',
        'is_block',
        'like',
        'dislike',
    ];

    // Quan hệ với bảng Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Quan hệ với bảng User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class, 'reportable_id');
    }


}
