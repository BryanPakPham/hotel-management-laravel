<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Danh sách khách hàng
    public function index(Request $request)
    {
        $query = DB::table('users')
            ->where('role', 'customer');

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;

            $query->where(function ($q) use ($keyword) {
                $q->where('name', 'like', '%' . $keyword . '%')
                    ->orWhere('email', 'like', '%' . $keyword . '%')
                    ->orWhere('phone', 'like', '%' . $keyword . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status);
        }

        $users = $query
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $totalCustomers = DB::table('users')
            ->where('role', 'customer')
            ->count();

        $activeCustomers = DB::table('users')
            ->where('role', 'customer')
            ->where('is_active', 1)
            ->count();

        $inactiveCustomers = DB::table('users')
            ->where('role', 'customer')
            ->where('is_active', 0)
            ->count();

        return view('admin.users.index', compact(
            'users',
            'totalCustomers',
            'activeCustomers',
            'inactiveCustomers'
        ));
    }

    // Hiển thị form thêm khách hàng
    public function create()
    {
        return view('admin.users.create');
    }

    // Lưu khách hàng mới
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'id_number' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email này đã được sử dụng.',
            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
        ]);

        DB::table('users')->insert([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'id_number' => $validated['id_number'] ?? null,
            'address' => $validated['address'] ?? null,
            'password' => Hash::make($validated['password']),
            'role' => 'customer',
            'is_active' => 1,
            'email_verified_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Thêm khách hàng thành công.');
    }

    // Xem chi tiết khách hàng
    public function show($id)
    {
        $user = DB::table('users')
            ->where('role', 'customer')
            ->where('id', $id)
            ->first();

        if (!$user) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Không tìm thấy khách hàng.');
        }

        return view('admin.users.show', compact('user'));
    }

    // Hiển thị form sửa khách hàng
    public function edit($id)
    {
        $user = DB::table('users')
            ->where('role', 'customer')
            ->where('id', $id)
            ->first();

        if (!$user) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Không tìm thấy khách hàng.');
        }

        return view('admin.users.edit', compact('user'));
    }

    // Cập nhật thông tin khách hàng
    public function update(Request $request, $id)
    {
        $user = DB::table('users')
            ->where('role', 'customer')
            ->where('id', $id)
            ->first();

        if (!$user) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Không tìm thấy khách hàng.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'id_number' => 'nullable|string|max:30',
            'address' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
        ], [
            'name.required' => 'Vui lòng nhập họ và tên.',
            'email.required' => 'Vui lòng nhập email.',
            'email.email' => 'Email không đúng định dạng.',
            'email.unique' => 'Email này đã được sử dụng.',
            'is_active.required' => 'Vui lòng chọn trạng thái tài khoản.',
        ]);

        DB::table('users')
            ->where('id', $id)
            ->where('role', 'customer')
            ->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'id_number' => $validated['id_number'] ?? null,
                'address' => $validated['address'] ?? null,
                'is_active' => $validated['is_active'],
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Cập nhật thông tin khách hàng thành công.');
    }

    // Xóa khách hàng nếu chưa có lịch sử đặt phòng
    public function destroy($id)
    {
        $user = DB::table('users')
            ->where('role', 'customer')
            ->where('id', $id)
            ->first();

        if (!$user) {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Không tìm thấy khách hàng hoặc tài khoản không hợp lệ.');
        }

        // Không xóa khách hàng đã có lịch sử đặt phòng
        $hasBookings = DB::table('bookings')
            ->where('user_id', $id)
            ->exists();

        if ($hasBookings) {
            return redirect()
                ->route('admin.users.index')
                ->with(
                    'error',
                    'Không thể xóa khách hàng này vì đã có lịch sử đặt phòng.'
                );
        }

        DB::table('users')
            ->where('id', $id)
            ->where('role', 'customer')
            ->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Xóa khách hàng thành công.');
    }
}