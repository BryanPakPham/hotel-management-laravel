<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RoomController extends Controller
{
    public function index(Request $request)
    {
        $query = DB::table('rooms')
            ->join('room_types', 'rooms.room_type_id', '=', 'room_types.id')
            ->select(
                'rooms.id',
                'rooms.room_number',
                'rooms.floor',
                'rooms.status',
                'rooms.note',
                'room_types.name as room_type_name',
                'room_types.base_price'
            );

        // Tìm kiếm theo số phòng
        if ($request->filled('keyword')) {
            $query->where(
                'rooms.room_number',
                'like',
                '%' . $request->keyword . '%'
            );
        }

        // Lọc theo trạng thái phòng
        if ($request->filled('status')) {
            $query->where('rooms.status', $request->status);
        }

        $rooms = $query
            ->orderBy('rooms.room_number')
            ->paginate(10)
            ->withQueryString();

        $totalRooms = DB::table('rooms')->count();

        $availableRooms = DB::table('rooms')
            ->where('status', 'available')
            ->count();

        $occupiedRooms = DB::table('rooms')
            ->where('status', 'occupied')
            ->count();

        $otherRooms = DB::table('rooms')
            ->whereIn('status', ['cleaning', 'maintenance'])
            ->count();

        return view('admin.rooms.index', compact(
            'rooms',
            'totalRooms',
            'availableRooms',
            'occupiedRooms',
            'otherRooms'
        ));
    }

    public function create()
    {
        $roomTypes = DB::table('room_types')
            ->orderBy('name')
            ->get();

        return view('admin.rooms.create', compact('roomTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => [
                'required',
                'string',
                'max:10',
                'unique:rooms,room_number',
            ],
            'room_type_id' => [
                'required',
                'integer',
                'exists:room_types,id',
            ],
            'floor' => ['required', 'integer', 'min:0', 'max:255'],
            'status' => [
                'required',
                'in:available,occupied,cleaning,maintenance',
            ],
            'note' => ['nullable', 'string'],
        ], [
            'room_number.required' => 'Vui lòng nhập số phòng.',
            'room_number.unique' => 'Số phòng này đã tồn tại.',
            'room_type_id.required' => 'Vui lòng chọn loại phòng.',
            'room_type_id.exists' => 'Loại phòng được chọn không hợp lệ.',
            'floor.required' => 'Vui lòng nhập tầng.',
            'status.required' => 'Vui lòng chọn trạng thái phòng.',
        ]);

        DB::table('rooms')->insert([
            ...$validated,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Thêm phòng thành công.');
    }

    public function edit(string $id)
    {
        $room = DB::table('rooms')->where('id', $id)->first();

        if (!$room) {
            abort(404);
        }

        $roomTypes = DB::table('room_types')
            ->orderBy('name')
            ->get();

        return view('admin.rooms.edit', compact('room', 'roomTypes'));
    }

    public function update(Request $request, string $id)
    {
        $room = DB::table('rooms')->where('id', $id)->first();

        if (!$room) {
            abort(404);
        }

        $validated = $request->validate([
            'room_number' => [
                'required',
                'string',
                'max:10',
                'unique:rooms,room_number,' . $id . ',id',
            ],
            'room_type_id' => [
                'required',
                'integer',
                'exists:room_types,id',
            ],
            'floor' => ['required', 'integer', 'min:0', 'max:255'],
            'status' => [
                'required',
                'in:available,occupied,cleaning,maintenance',
            ],
            'note' => ['nullable', 'string'],
        ], [
            'room_number.required' => 'Vui lòng nhập số phòng.',
            'room_number.unique' => 'Số phòng này đã được sử dụng.',
            'room_type_id.required' => 'Vui lòng chọn loại phòng.',
            'room_type_id.exists' => 'Loại phòng được chọn không hợp lệ.',
            'floor.required' => 'Vui lòng nhập tầng.',
            'status.required' => 'Vui lòng chọn trạng thái phòng.',
        ]);

        DB::table('rooms')
            ->where('id', $id)
            ->update([
                ...$validated,
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Cập nhật phòng thành công.');
    }

    public function destroy(string $id)
    {
        $room = DB::table('rooms')->where('id', $id)->first();

        if (!$room) {
            abort(404);
        }

        $hasBookings = DB::table('booking_rooms')
            ->where('room_id', $id)
            ->exists();

        if ($hasBookings) {
            return redirect()
                ->route('admin.rooms.index')
                ->with(
                    'error',
                    'Không thể xóa phòng đã có lịch sử đặt phòng.'
                );
        }

        if ($room->status === 'occupied') {
            return redirect()
                ->route('admin.rooms.index')
                ->with('error', 'Không thể xóa phòng đang có khách.');
        }

        DB::table('rooms')->where('id', $id)->delete();

        return redirect()
            ->route('admin.rooms.index')
            ->with('success', 'Xóa phòng thành công.');
    }
}
