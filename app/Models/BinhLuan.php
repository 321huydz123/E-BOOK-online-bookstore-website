<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BinhLuan extends Model
{
    protected $table = 'binh_luan';
    protected $fillable = [
        'id_user',
        'id_san_pham',
        'noi_dung_binh_luan',
        'ngay_binh_luan',
        'danh_gia'
    ];
    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'id_san_pham', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
