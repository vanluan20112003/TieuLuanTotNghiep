<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpinHistory extends Model
{
    use HasFactory;

    protected $table = 'spin_history'; // Xác định tên bảng là 'spin_history'
    
    protected $fillable = ['user_id', 'result'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
