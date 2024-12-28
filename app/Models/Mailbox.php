<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mailbox extends Model
{
    // Chỉ định tên bảng
    protected $table = 'mailbox';

    // Khai báo các trường có thể được gán giá trị hàng loạt
    protected $fillable = [
        'user_id',
        'created_at',
        'updated_at',
    ];

    // Quan hệ với bảng MailboxDetail
    public function mailboxDetails(): HasMany
    {
        return $this->hasMany(MailboxDetail::class, 'mailbox_id');
    }

    // Quan hệ với bảng User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
