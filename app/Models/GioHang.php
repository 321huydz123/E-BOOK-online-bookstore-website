<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GioHang extends Model
{
    protected $table = 'gio_hang';
    protected $fillable = ['id_user', 'id_san_pham', 'so_luong'];
    public $timestamps = false;
    public function san_pham()
    {
        return $this->belongsTo(SanPham::class, 'id_san_pham', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
