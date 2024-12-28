<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name','product_count', 'image','created_at','updated_at'];

    // Nếu bạn muốn lấy số lượng sản phẩm thuộc category này, có thể thêm một quan hệ (relationship) như sau:
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
