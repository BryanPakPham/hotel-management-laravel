<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    // Hiển thị danh sách dịch vụ
    public function index()
    {
        $services = DB::table('services')
            ->orderBy('id')
            ->paginate(10);

        return view('admin.services.index', compact('services'));
    }

    // Hiển thị form thêm dịch vụ
    public function create()
    {
        return view('admin.services.create');
    }

    // Lưu dịch vụ mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:100',
            'description' => 'nullable|string',
            'is_active' => 'required|in:0,1',
        ], [
            'name.required' => 'Vui lòng nhập tên dịch vụ.',
            'name.max' => 'Tên dịch vụ không được vượt quá 255 ký tự.',
            'price.required' => 'Vui lòng nhập giá dịch vụ.',
            'price.numeric' => 'Giá dịch vụ phải là số.',
            'price.min' => 'Giá dịch vụ không được nhỏ hơn 0.',
            'unit.required' => 'Vui lòng nhập đơn vị tính.',
            'unit.max' => 'Đơn vị tính không được vượt quá 100 ký tự.',
            'is_active.required' => 'Vui lòng chọn trạng thái dịch vụ.',
            'is_active.in' => 'Trạng thái dịch vụ không hợp lệ.',
        ]);

        DB::table('services')->insert([
            'name' => $request->name,
            'price' => $request->price,
            'unit' => $request->unit,
            'description' => $request->description,
            'is_active' => $request->is_active,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Thêm dịch vụ thành công.');
    }

    // Hiển thị form sửa dịch vụ
    public function edit($id)
    {
        $service = DB::table('services')
            ->where('id', $id)
            ->first();

        if (!$service) {
            abort(404);
        }

        return view('admin.services.edit', compact('service'));
    }

    // Cập nhật dịch vụ
    public function update(Request $request, $id)
    {
        $service = DB::table('services')
            ->where('id', $id)
            ->first();

        if (!$service) {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'unit' => 'required|string|max:100',
            'description' => 'nullable|string',
            'is_active' => 'required|in:0,1',
        ], [
            'name.required' => 'Vui lòng nhập tên dịch vụ.',
            'name.max' => 'Tên dịch vụ không được vượt quá 255 ký tự.',
            'price.required' => 'Vui lòng nhập giá dịch vụ.',
            'price.numeric' => 'Giá dịch vụ phải là số.',
            'price.min' => 'Giá dịch vụ không được nhỏ hơn 0.',
            'unit.required' => 'Vui lòng nhập đơn vị tính.',
            'unit.max' => 'Đơn vị tính không được vượt quá 100 ký tự.',
            'is_active.required' => 'Vui lòng chọn trạng thái dịch vụ.',
            'is_active.in' => 'Trạng thái dịch vụ không hợp lệ.',
        ]);

        DB::table('services')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'price' => $request->price,
                'unit' => $request->unit,
                'description' => $request->description,
                'is_active' => $request->is_active,
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Cập nhật dịch vụ thành công.');
    }

    // Xóa dịch vụ
    public function destroy($id)
    {
        $service = DB::table('services')
            ->where('id', $id)
            ->first();

        if (!$service) {
            abort(404);
        }

        DB::table('services')
            ->where('id', $id)
            ->delete();

        return redirect()
            ->route('admin.services.index')
            ->with('success', 'Xóa dịch vụ thành công.');
    }
}
