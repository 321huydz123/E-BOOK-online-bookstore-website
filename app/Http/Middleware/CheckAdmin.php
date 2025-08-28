<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        $user = Auth::user();
        if ($user->trang_thai != 1) {
            Auth::logout();
            return redirect()->route('login')->with('alert', [
                'type' => 'error',
                'message' => 'Tài khoản bị khóa',
            ]);
        }
        if ($user->quyen == 1) {
            Auth::logout();
            return redirect()->route('login')->with('alert', [
                'type' => 'error',
                'message' => 'Bạn không đủ quyền để truy cập vào trang quản trị ',
            ]);
        }
        return $next($request);
    }
}