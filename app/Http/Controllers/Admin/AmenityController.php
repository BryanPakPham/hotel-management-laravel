<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AmenityController extends Controller
{
    // Hiển thị danh sách tiện nghi
    public function index()
    {
        $amenities = DB::table('amenities')
            ->orderBy('id')
            ->paginate(10);

        return view('admin.amenities.index', compact('amenities'));
    }

    // Hiển thị form thêm tiện nghi
    public function create()
    {
        return view('admin.amenities.create');
    }

    // Lưu tiện nghi mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Vui lòng nhập tên tiện nghi.',
            'name.max' => 'Tên tiện nghi không được vượt quá 255 ký tự.',
        ]);

        DB::table('amenities')->insert([
            'name' => $request->name,
            'icon' => $request->icon,
            'description' => $request->description,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('admin.amenities.index')
            ->with('success', 'Thêm tiện nghi thành công.');
    }

    // Hiển thị form sửa tiện nghi
    public function edit($id)
    {
        $amenity = DB::table('amenities')
            ->where('id', $id)
            ->first();

        if (!$amenity) {
            abort(404);
        }

        return view('admin.amenities.edit', compact('amenity'));
    }

    // Cập nhật tiện nghi
    public function update(Request $request, $id)
    {
        $amenity = DB::table('amenities')
            ->where('id', $id)
            ->first();

        if (!$amenity) {
            abort(404);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ], [
            'name.required' => 'Vui lòng nhập tên tiện nghi.',
            'name.max' => 'Tên tiện nghi không được vượt quá 255 ký tự.',
        ]);

        DB::table('amenities')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'icon' => $request->icon,
                'description' => $request->description,
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('admin.amenities.index')
            ->with('success', 'Cập nhật tiện nghi thành công.');
    }

    // Xóa tiện nghi
    public function destroy($id)
    {
        $amenity = DB::table('amenities')
            ->where('id', $id)
            ->first();

        if (!$amenity) {
            abort(404);
        }

        DB::table('amenities')
            ->where('id', $id)
            ->delete();

        return redirect()
            ->route('admin.amenities.index')
            ->with('success', 'Xóa tiện nghi thành công.');
    }
}