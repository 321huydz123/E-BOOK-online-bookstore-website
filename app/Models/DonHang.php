<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    use HasFactory;
    protected $table = 'don_hang';
    protected $fillable = ['id_user', 'thoi_gian', 'ghi_chu', 'trang_thai_don_hang', 'tong_tien', 'dia_chi', 'sdt'];
    public function chiTietSanPham()
    {
        return $this->hasMany(ChiTietDonHang::class, 'id_don_hang', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
