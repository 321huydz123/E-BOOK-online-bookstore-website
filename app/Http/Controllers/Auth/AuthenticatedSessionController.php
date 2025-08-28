<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();
        if (auth()->user()->trang_thai != 1) {
            Auth::logout(); // Đăng xuất người dùng
            return redirect()->route('login')->with('alert', [
                'type' => 'error',
                'message' => 'Tài Khoản của bạn đã bị khóa ',
            ]);
        }
        if (auth()->user()->quyen == 2) {
            return redirect()->intended(route('thong-ke')); // Điều hướng admin
        } else {
            return redirect()->intended(route('web.trang-chu'));
        }

        // return redirect()->intended(route('web.trang-chu', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}