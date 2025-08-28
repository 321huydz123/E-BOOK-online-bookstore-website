<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    protected $table = 'san_pham';
    protected $fillable = [
        'ten_san_pham',
        'gia_ban',
        'gia_goc',
        'mo_ta',
        'so_luong',
        'so_trang',
        'id_loai_san_pham',
        'id_tac_gia',
        'id_nha_san_xuat',
        'id_nha_phat_hanh',
        'nam_xb',
        'kich_thuoc',
        'trong_luong',
        'ngay_nhap',
        'trang_thai',
    ];
    public $timestamps = false;
    public function loaiSanPham()
    {
        return $this->belongsTo(LoaiSanPham::class, 'id_loai_san_pham', 'id');
    }

    public function tacGia()
    {
        return $this->belongsTo(TacGia::class, 'id_tac_gia');
    }

    public function nhaSanXuat()
    {
        return $this->belongsTo(NhaSanXuat::class, 'id_nha_san_xuat');
    }

    public function nhaPhatHanh()
    {
        return $this->belongsTo(NhaPhatHanh::class, 'id_nha_phat_hanh');
    }
    public function hinhAnhs()
    {
        return $this->hasMany(HinhAnh::class, 'id_san_pham');
    }
    public function hinhAnh()
    {
        return $this->hasOne(HinhAnh::class, 'id_san_pham');
    }
    public function binhLuan()
    {
        return $this->hasMany(BinhLuan::class, 'id_san_pham');
    }
    // public function anh_san_pham()
    // {
    //     return $this->hasMany(AnhSanPham::class, 'id_san_pham');
    // }
}
