<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OtpController extends Controller
{
    public function showVerifyForm()
    {
        return view('auth.verify'); // Giao diện để nhập mã xác minh
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'code' => 'required|numeric',
        ]);

        // Kiểm tra thông tin người dùng từ session
        $userData = $request->session()->get('user_data');

        if ($userData && $userData['email'] === $request->email && $userData['ma_xac_nhan'] == $request->code) {
            // Lưu người dùng vào cơ sở dữ liệu
            $user = User::create([
                'ten' => $userData['ten'],
                'email' => $userData['email'],
                'mat_khau' => $userData['mat_khau'],
                'email_verified_at' => now(), // Đánh dấu email đã được xác minh
                'ma_xac_nhan' => $userData['ma_xac_nhan'],
            ]);

            // Đăng nhập người dùng
            Auth::login($user);

            // Xóa dữ liệu người dùng tạm thời trong session
            $request->session()->forget('user_data');
            return redirect()->route('web.trang-chu')->with('success', 'Tài khoản đã được xác minh và tạo thành công!');
        }

        return back()->with('error', 'Mã xác nhận không hợp lệ.');
    }
}