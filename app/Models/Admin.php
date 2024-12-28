<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class Admin extends Authenticatable
{
    use Notifiable;

    // Chỉ định guard cho admin
    protected $guard = 'admin';

    // Tên bảng trong database
    protected $table = 'admins';

    // Các cột có thể được điền vào
    protected $fillable = [
        'name',
        'email',
        'password',
        'google2fa_secret',
    ];

    // Ẩn các trường này khi xuất ra JSON
    protected $hidden = [
        'password',
        'remember_token',
        'google2fa_secret',
    ];

    /**
     * Mã hóa mật khẩu trước khi lưu vào database.
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = Hash::make($password);
    }

    /**
     * Kiểm tra xem admin đã kích hoạt 2FA hay chưa.
     *
     * @return bool
     */
    public function hasEnabled2FA()
    {
        return !is_null($this->google2fa_secret);
    }

    /**
     * Lấy mã 2FA của admin.
     *
     * @return string|null
     */
    public function get2FASecret()
    {
        return $this->google2fa_secret;
    }

    /**
     * Kích hoạt 2FA cho admin.
     *
     * @param string $secret
     * @return void
     */
    public function enable2FA($secret)
    {
        $this->google2fa_secret = $secret;
        $this->save();
    }

    /**
     * Vô hiệu hóa 2FA cho admin.
     *
     * @return void
     */
    public function disable2FA()
    {
        $this->google2fa_secret = null;
        $this->save();
    }
}
