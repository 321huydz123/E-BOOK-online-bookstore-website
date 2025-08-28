<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NhaSanXuat extends Model
{
    protected $table = 'nha_san_xuat';
    protected $fillable = ['ten_nha_san_xuat', 'trang_thai',];
    public $timestamps = false;
}
