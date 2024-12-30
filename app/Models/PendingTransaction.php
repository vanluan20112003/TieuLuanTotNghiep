<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingTransaction extends Model
{
    use HasFactory;

    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'pending_transactions';

    // Các cột có thể được điền giá trị (mass assignable)
    protected $fillable = [
        'transaction_type',
        'the_da_nang_id',
        'amount',
        'bank_info',
        'evidence',
        'status',
    ];

    // Định nghĩa các giá trị mặc định cho các trường
    protected $attributes = [
        'status' => 'pending',
    ];

    // Các trạng thái giao dịch
    const STATUS_PENDING = 'pending';
    const STATUS_APPROVED = 'approved';
    const STATUS_REJECTED = 'rejected';

    /**
     * Quan hệ với bảng TheDaNang (thẻ đa năng)
     */
    public function theDaNang()
    {
        return $this->belongsTo(TheDaNang::class, 'the_da_nang_id');
    }

    /**
     * Accessor để định dạng số tiền dưới dạng tiền tệ
     */
    public function getFormattedAmountAttribute()
    {
        return number_format($this->amount, 0, ',', '.') . ' ₫';
    }

    /**
     * Kiểm tra trạng thái có phải đang chờ duyệt không
     */
    public function isPending()
    {
        return $this->status === self::STATUS_PENDING;
    }

    /**
     * Kiểm tra trạng thái có phải đã được duyệt không
     */
    public function isApproved()
    {
        return $this->status === self::STATUS_APPROVED;
    }

    /**
     * Kiểm tra trạng thái có phải đã bị từ chối không
     */
    public function isRejected()
    {
        return $this->status === self::STATUS_REJECTED;
    }
}
