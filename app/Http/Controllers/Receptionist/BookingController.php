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

        return view('receptionist.bookings.show', compact('dat'));
    }
}
