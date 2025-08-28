<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoaiSanPham extends Model
{
    //
    protected $table = 'loai_san_pham';


    // Các cột có thể gán giá trị hàng loạt
    protected $fillable = ['ten_loai_san_pham', 'trang_thai'];

    // Tắt timestamps nếu bảng không có `created_at` và `updated_at`
    public $timestamps = false;

    // Định nghĩa quan hệ với bảng `san_pham`
    public function sanPham()
    {
        return $this->hasMany(SanPham::class, 'id_loai_san_pham', 'id');
    }
}
