<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function index()
    {
        $datPhong = DB::table('bookings')
            ->leftJoin('users', 'bookings.user_id', '=', 'users.id')
            ->select(
                'bookings.id',
                'bookings.booking_code',
                'bookings.guest_name',
                'bookings.guest_phone',
                'bookings.check_in_date',
                'bookings.check_out_date',
                'bookings.num_adults',
                'bookings.num_children',
                'bookings.status',
                'bookings.total_amount',
                'users.name as tenTaiKhoan'
            )
            ->orderByDesc('bookings.created_at')
            ->paginate(10);

        return view(
            'receptionist.bookings.index',
            compact('datPhong')
        );
    }

    // Chi tiet don dat phong va danh sach phong da dat
    public function show($id)
    {
        $dat = DB::table('bookings')
            ->leftJoin('users', 'bookings.user_id', '=', 'users.id')
            ->select(
                'bookings.id',
                'bookings.booking_code',
                'bookings.guest_name',
                'bookings.guest_phone',
                'bookings.check_in_date',
                'bookings.check_out_date',
                'bookings.num_adults',
                'bookings.num_children',
                'bookings.status',
                'bookings.total_amount',
                'users.name as tenTaiKhoan'
            )
            ->where('bookings.id', $id)
            ->first();

        if (!$dat) {
            abort(404, 'Không tìm thấy đơn đặt phòng.');
        }

        // Lay tat ca cac phong thuoc don dat
        $cacPhong = DB::table('booking_rooms')
            ->join(
                'room_types',
                'booking_rooms.room_type_id',
                '=',
                'room_types.id'
            )
            ->leftJoin(
                'rooms',
                'booking_rooms.room_id',
                '=',
                'rooms.id'
            )
            ->leftJoin(
                'stay_records',
                'booking_rooms.id',
                '=',
                'stay_records.booking_room_id'
            )
            ->where('booking_rooms.booking_id', $dat->id)
            ->select(
                'booking_rooms.id as booking_room_id',
                'booking_rooms.price_per_night',
                'room_types.name as room_type_name',
                'rooms.room_number',
                'rooms.status as room_status',
                'stay_records.actual_check_in',
                'stay_records.actual_check_out'
            )
            ->orderBy('booking_rooms.id')
            ->get();

        return view(
            'receptionist.bookings.show',
            compact('dat', 'cacPhong')
        );
    }

    // Xac nhan don dat phong
    public function confirm($id)
    {
        $dat = DB::table('bookings')
            ->where('id', $id)
            ->first();

        if (!$dat) {
            abort(404, 'Không tìm thấy đơn đặt phòng.');
        }

        if ($dat->status != 'pending') {
            return back()->with(
                'error',
                'Chỉ có đơn đang chờ xác nhận mới được xác nhận.'
            );
        }

        DB::table('bookings')
            ->where('id', $id)
            ->where('status', 'pending')
            ->update([
                'status' => 'confirmed',
                'updated_at' => now()
            ]);

        return back()->with(
            'success',
            'Xác nhận đơn đặt phòng thành công.'
        );
    }

    // Huy don dat phong
    public function cancel($id)
    {
        $dat = DB::table('bookings')
            ->where('id', $id)
            ->first();

        if (!$dat) {
            abort(404, 'Không tìm thấy đơn đặt phòng.');
        }

        // Chi cho phep huy don dang cho hoac da xac nhan
        if (!in_array($dat->status, ['pending', 'confirmed'])) {
            return back()->with(
                'error',
                'Đơn đặt phòng này không thể hủy.'
            );
        }

        // Kiem tra khach da nhan phong hay chua
        $daNhanPhong = DB::table('booking_rooms')
            ->join(
                'stay_records',
                'booking_rooms.id',
                '=',
                'stay_records.booking_room_id'
            )
            ->where('booking_rooms.booking_id', $id)
            ->whereNotNull('stay_records.actual_check_in')
            ->exists();

        if ($daNhanPhong) {
            return back()->with(
                'error',
                'Không thể hủy đơn vì khách đã nhận phòng.'
            );
        }

        DB::table('bookings')
            ->where('id', $id)
            ->update([
                'status' => 'cancelled',
                'updated_at' => now()
            ]);

        return back()->with(
            'success',
            'Hủy đơn đặt phòng thành công.'
        );
    }
}
