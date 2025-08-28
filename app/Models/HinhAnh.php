<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HinhAnh extends Model
{
    protected $table = 'anh_san_pham';
    protected $fillable = ['hinh_anh', 'id_san_pham'];
    public $timestamps = false;

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'id_san_pham');
    }
}
