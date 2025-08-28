<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    // protected $attributes = [
    //     'password' => 'password', // Đặt alias cho 'password' thành 'password'
    // ];
    protected $table = 'users';


    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'ten',
        'email',
        'email_verified_at',
        'password', // Assuming 'password' is the password field
        'sdt', // Assuming this is the phone number field
        'anh', // Assuming this is the image field
        'trang_thai',
        'quyen',
        'ma_xac_nhan', // Assuming this is the verification code field
        'remember_token'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array<string, string>
     */
    protected $attributes = [
        'password' => 'password', // Đặt alias cho 'password' thành 'password'
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
    public function donHang()
    {
        return $this->hasMany(DonHang::class, 'id_user');
    }
    // public function conversationsAsUserOne()
    // {
    //     return $this->hasMany(CuocTroChuyen::class, 'user1_id');
    // }

    // // Liên kết với cuộc trò chuyện mà người dùng tham gia (là người thứ hai)
    // public function conversationsAsUserTwo()
    // {
    //     return $this->hasMany(CuocTroChuyen::class, 'user2_id');
    // }

    // // Liên kết tất cả các tin nhắn mà người dùng đã gửi
    // public function messages()
    // {
    //     return $this->hasMany(TinNhan::class, 'nguoi_gui', 'id');
    // }

    // // Lấy tất cả các cuộc trò chuyện mà người dùng tham gia
    // public function conversations()
    // {
    //     return CuocTroChuyen::where('user1_id', $this->id)
    //         ->orWhere('user2_id', $this->id)
    //         ->get();
    // }
    public function conversations()
    {
        return $this->hasMany(CuocTroChuyen::class, 'user1_id')->orWhere('user2_id', $this->id);
    }

    public function messages()
    {
        return $this->hasMany(TinNhan::class, 'nguoi_gui');
    }
}
