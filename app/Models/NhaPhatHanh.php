<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NhaPhatHanh extends Model
{
    protected $table = 'nha_phat_hanh';
    protected $fillable = ['ten_nha_phat_hanh', 'trang_thai',];
    public $timestamps = false;
}
