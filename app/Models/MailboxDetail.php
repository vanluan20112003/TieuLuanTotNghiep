<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MailboxDetail extends Model
{
    // Chỉ định tên bảng
    protected $table = 'mailbox_detail';

    // Khai báo các trường có thể được gán giá trị hàng loạt
    protected $fillable = [
        'mailbox_id',
        'content',
        'is_read_user',
        'is_read_admin',
        'sent_at',
        'is_delete',
        'created_at',
        'updated_at',
        'is_user_send',
    ];

    // Quan hệ với bảng Mailbox
    public function mailbox()
    {
        return $this->belongsTo(Mailbox::class);
    }
}
