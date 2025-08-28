<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CuocTroChuyen extends Model
{
    protected $table = 'cuoc_tro_chuyen';
    protected $fillable = ['user1_id', 'user2_id', 'ten_cuoc_tro_chuyen', 'created_at', 'updated_at'];


    public function messages()
    {
        return $this->hasMany(TinNhan::class, 'cuoc_tro_chuyen_id');
    }

    // Liên kết với người dùng thứ nhất
    public function userOne()
    {
        return $this->belongsTo(User::class, 'user1_id', 'id');
    }

    // Liên kết với người dùng thứ hai
    public function userTwo()
    {
        return $this->belongsTo(User::class, 'user2_id', 'id');
    }

    // Kiểm tra xem một người dùng có thuộc cuộc trò chuyện này hay không
    public function hasParticipant($userId)
    {
        return $this->user1_id == $userId || $this->user2_id == $userId;
    }
}
