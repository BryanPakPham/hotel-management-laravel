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
            abort(404, 'Khong tim thay don dat phong.');
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
            abort(404, 'Khong tim thay don dat phong.');
        }

        if ($dat->status != 'pending') {
            return back()->with(
                'error',
                'Chi co don dang cho xac nhan moi duoc xac nhan.'
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
            'Xac nhan don dat phong thanh cong.'
        );
    }
}
