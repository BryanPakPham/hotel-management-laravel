<?php

namespace App\Http\Middleware\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(
        Request $request,
        Closure $next,
        string ...$roles
    ): Response {
        // Kiểm tra người dùng đã đăng nhập chưa
        if (!$request->user()) {
            abort(401, 'Vui lòng đăng nhập.');
        }

        // Kiểm tra tài khoản có đang hoạt động không
        if (!$request->user()->is_active) {
            abort(403, 'Tài khoản đã bị khóa.');
        }

        // Kiểm tra vai trò có được phép truy cập không
        if (!in_array($request->user()->role, $roles, true)) {
            abort(403, 'Bạn không có quyền truy cập chức năng này.');
        }

        return $next($request);
    }
}