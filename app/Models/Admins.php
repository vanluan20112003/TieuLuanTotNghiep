<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admins extends Model
{
    use HasFactory;

    // Định nghĩa bảng sử dụng trong model
    protected $table = 'admins';

    // Đảm bảo id không phải là tự động tăng
    public $incrementing = false;  // Đặt false nếu id không phải kiểu tự động tăng

    // Kiểu dữ liệu của id là string
    protected $keyType = 'string';  // Chỉ định rằng id là kiểu string (varchar)

    // Các trường có thể gán giá trị
    protected $fillable = [
        'id', 
        'user_id', 
        'role', 
        'manage_products', 
        'manage_users', 
        'manage_staff', 
        'manage_promotions', 
        'manage_posts', 
        'manage_orders', 
        'manage_reservations', 
        'manage_finance', 

        'manage_system',
    ];

    // Khai báo quan hệ với bảng User (Admin belongs to User)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Tạo các accessors và mutators nếu cần (ví dụ: quản lý quyền hạn)
    public function hasPermission($permission)
{
    // Kiểm tra xem quyền có tồn tại trong fillable không
    if (in_array($permission, $this->fillable)) {
        return $this->{$permission} == 1;
    }
    return false;
}

    // Tạo các phương thức bổ sung nếu cần để kiểm tra quyền của admin
    public function canManageProducts()
    {
        return $this->manage_products;
    }

    public function canManageUsers()
    {
        return $this->manage_users;
    }

    public function canManageOrders()
    {
        return $this->manage_orders;
    }

    // Và các phương thức khác tương tự cho các quyền quản lý
}
