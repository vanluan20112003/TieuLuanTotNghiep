<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $table = 'notification';

    protected $fillable = [
        'user_id',
        'content',
        'type', // 'discount', 'order', etc.
        'is_user_read', // boolean (0/1)
        'created_at',
        'updated_at'
    ];

    // Liên kết với user
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
