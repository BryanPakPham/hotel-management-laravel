<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class RoomTypeController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('room_types')
            ->select(
                'id',
                'name',
                'slug',
                'description',
                'base_price',
                'max_adults',
                'max_children',
                'bed_type',
                'area'
            );

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        $roomTypes = $query
            ->orderBy('name')
            ->paginate(10)
            ->withQueryString();

        return view('admin.room-types.index', compact('roomTypes'));
    }

    public function create()
    {
        return view('admin.room-types.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'base_price' => ['required', 'numeric', 'min:0', 'max:9999999999.99'],
            'max_adults' => ['required', 'integer', 'min:1', 'max:255'],
            'max_children' => ['required', 'integer', 'min:0', 'max:255'],
            'bed_type' => ['required', 'string', 'max:100'],
            'area' => ['required', 'numeric', 'gt:0', 'max:9999.99'],
        ], [
            'name.required' => 'Vui lòng nhập tên loại phòng.',
            'base_price.required' => 'Vui lòng nhập giá cơ bản.',
            'base_price.numeric' => 'Giá phòng phải là số.',
            'base_price.min' => 'Giá phòng không được âm.',
            'max_adults.required' => 'Vui lòng nhập số người lớn tối đa.',
            'max_adults.min' => 'Số người lớn tối thiểu là 1.',
            'max_children.required' => 'Vui lòng nhập số trẻ em tối đa.',
            'bed_type.required' => 'Vui lòng nhập loại giường.',
            'area.required' => 'Vui lòng nhập diện tích phòng.',
            'area.gt' => 'Diện tích phải lớn hơn 0.',
        ]);

        $validated['slug'] = $this->generateUniqueSlug($validated['name']);

        DB::table('room_types')->insert([
            ...$validated,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('admin.room-types.index')
            ->with('success', 'Thêm loại phòng thành công.');
    }

    public function edit(string $id)
    {
        $roomType = DB::table('room_types')->where('id', $id)->first();

        if (!$roomType) {
            abort(404);
        }

        return view('admin.room-types.edit', compact('roomType'));
    }

    public function update(Request $request, string $id)
    {
        $roomType = DB::table('room_types')->where('id', $id)->first();

        if (!$roomType) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'description' => ['nullable', 'string'],
            'base_price' => ['required', 'numeric', 'min:0', 'max:9999999999.99'],
            'max_adults' => ['required', 'integer', 'min:1', 'max:255'],
            'max_children' => ['required', 'integer', 'min:0', 'max:255'],
            'bed_type' => ['required', 'string', 'max:100'],
            'area' => ['required', 'numeric', 'gt:0', 'max:9999.99'],
        ], [
            'name.required' => 'Vui lòng nhập tên loại phòng.',
            'base_price.required' => 'Vui lòng nhập giá cơ bản.',
            'base_price.numeric' => 'Giá phòng phải là số.',
            'base_price.min' => 'Giá phòng không được âm.',
            'max_adults.required' => 'Vui lòng nhập số người lớn tối đa.',
            'max_adults.min' => 'Số người lớn tối thiểu là 1.',
            'max_children.required' => 'Vui lòng nhập số trẻ em tối đa.',
            'bed_type.required' => 'Vui lòng nhập loại giường.',
            'area.required' => 'Vui lòng nhập diện tích phòng.',
            'area.gt' => 'Diện tích phải lớn hơn 0.',
        ]);

        $validated['slug'] = $this->generateUniqueSlug(
            $validated['name'],
            (int) $id
        );

        DB::table('room_types')
            ->where('id', $id)
            ->update([
                ...$validated,
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('admin.room-types.index')
            ->with('success', 'Cập nhật loại phòng thành công.');
    }

    public function destroy(string $id)
    {
        $roomType = DB::table('room_types')->where('id', $id)->first();

        if (!$roomType) {
            abort(404);
        }

        $hasRooms = DB::table('rooms')
            ->where('room_type_id', $id)
            ->exists();

        $hasBookings = DB::table('booking_rooms')
            ->where('room_type_id', $id)
            ->exists();

        if ($hasRooms || $hasBookings) {
            return redirect()
                ->route('admin.room-types.index')
                ->with(
                    'error',
                    'Không thể xóa loại phòng đã có phòng thực tế hoặc lịch sử đặt phòng liên quan.'
                );
        }

        DB::table('room_types')->where('id', $id)->delete();

        return redirect()
            ->route('admin.room-types.index')
            ->with('success', 'Xóa loại phòng thành công.');
    }

    private function generateUniqueSlug(string $name, ?int $ignoreId = null): string
    {
        $baseSlug = Str::slug($name);

        if ($baseSlug === '') {
            $baseSlug = 'loai-phong';
        }

        $slug = $baseSlug;
        $counter = 1;

        while (
            DB::table('room_types')
                ->where('slug', $slug)
                ->when($ignoreId, function ($query) use ($ignoreId) {
                    $query->where('id', '<>', $ignoreId);
                })
                ->exists()
        ) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
