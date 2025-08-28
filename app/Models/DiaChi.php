<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DiaChi extends Model
{
    use HasFactory;
    protected $table = 'dia_chi';
    protected $fillable = ['id', 'id_user', 'dia_chi', 'trang_thai'];
}
