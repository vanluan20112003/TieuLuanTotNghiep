<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InventoryEntry extends Model
{
    use HasFactory;

    // Đặt tên bảng tương ứng với tên bảng trong cơ sở dữ liệu
    protected $table = 'inventory_entries';

    // Đặt tên cột mà bạn muốn gán giá trị tự động
    protected $fillable = [
        'product_id', 
        'purchase_price', 
        'quantity', 
        'mode'
    ];

    // Cột có kiểu timestamp tự động (created_at và updated_at) sẽ được Laravel tự động xử lý.
    // Nếu bạn không muốn các cột này tự động xử lý, có thể tắt bằng cách:
    // public $timestamps = false;

    // Liên kết với bảng 'products' qua cột 'product_id'
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    // Cập nhật tổng giá nhập khi giá nhập và số lượng thay đổi
    public function getTotalPurchasePriceAttribute()
    {
        return $this->purchase_price * $this->quantity;
    }

    // Các phương thức khác có thể được thêm vào nếu cần
}
