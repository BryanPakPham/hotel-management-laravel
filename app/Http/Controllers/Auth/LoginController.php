<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Hiển thị trang đăng nhập
    public function showLogin()
    {
        return view('auth.login');
    }

    // Xử lý đăng nhập
    public function login(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if (! $user->is_active) {
                Auth::logout();

                return back()->withErrors([
                    'email' => 'Tài khoản đã bị vô hiệu hóa.',
                ]);
            }

            if ($user->role == 'admin') {
                return redirect()->route('admin.dashboard');
            }

            if ($user->role == 'receptionist') {
                return redirect()->route('receptionist.dashboard');
            }

            if ($user->role == 'customer') {
                return redirect()->route('home');
            }

            Auth::logout();

            return back()->withErrors([
                'email' => 'Tài khoản chưa được phân quyền hợp lệ.',
            ]);
        }

        return back()->withErrors([
            'email' => 'Đăng nhập thất bại: Email hoặc mật khẩu không chính xác.',
        ])->onlyInput('email');
    }

    // Đăng xuất
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
