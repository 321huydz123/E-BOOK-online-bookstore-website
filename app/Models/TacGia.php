<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TacGia extends Model
{
    protected $table = 'tac_gia';
    protected $fillable = ['ten_tac_gia', 'trang_thai',];
    public $timestamps = false;
}
