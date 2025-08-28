<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ChiTietDonHang extends Model
{
    use HasFactory;
    protected $table = 'chi_tiet_don_hang';
    protected $fillable = ['id_san_pham', 'id_don_hang', 'gia', 'so_luong', 'ten_san_pham'];
    public function donHang()
    {
        return $this->belongsTo(DonHang::class, 'id_don_hang', 'id');
    }
    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'id_san_pham', 'id');
    }
}
