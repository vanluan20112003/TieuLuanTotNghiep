<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'transactions';

    // Các cột có thể được gán giá trị
    protected $fillable = [
        'the_da_nang_id',  // ID tài khoản The Da Nang
        'loai_giao_dich',  // Loại giao dịch: 'nap' hoặc 'rut'
        'so_tien',         // Số tiền giao dịch
    ];

    /**
     * Liên kết với model TheDaNang (quan hệ belongsTo)
     * Mỗi giao dịch thuộc về một tài khoản TheDaNang.
     */
    public function theDaNang()
    {
        return $this->belongsTo(TheDaNang::class, 'the_da_nang_id');
    }
}
