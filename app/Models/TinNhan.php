<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TinNhan extends Model
{
    protected $table = 'tin_nhan';
    protected $fillable = [
        'cuoc_tro_chuyen_id',
        'nguoi_gui',
        'noi_dung',

        'created_at',
        'updated_at',
        'trang_thai'
    ];
    public function conversation()
    {
        return $this->belongsTo(CuocTroChuyen::class, 'cuoc_tro_chuyen_id');
    }
    public function sender()
    {
        return $this->belongsTo(User::class, 'nguoi_gui', 'id');
    }
}
