<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\Mail;
use App\Mail\VerificationMail;
use Illuminate\Validation\Rules\Password;


class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'ten' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Password::min(8)],
        ], [
    'password.required' => 'Vui lòng nhập mật khẩu.',
    'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
    'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
]);

        $verificationCode = rand(100000, 999999);

        $request->session()->put('user_data', [
            'ten' => $request->ten,
            'email' => $request->email,
            'password' => bcrypt($request->mat_khau), // Mã hóa mật khẩu
            'ma_xac_nhan' => $verificationCode,
        ]);
        // dd($request->session()->get('user_data'));
        $request->session()->put('email', $request->email);

        Mail::to($request->email)->send(new VerificationMail($verificationCode));

        return redirect()->route('verification.show');

        // die(12);
    }
}
