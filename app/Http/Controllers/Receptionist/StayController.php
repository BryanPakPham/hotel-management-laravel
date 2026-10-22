<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StayController extends Controller
{
    public function index()
    {
        
        $datPhong = DB::table('bookings')
            ->join('booking_rooms', 'bookings.id', '=', 'booking_rooms.booking_id')
            ->join('room_types', 'booking_rooms.room_type_id', '=', 'room_types.id')
            ->leftJoin('rooms', 'booking_rooms.room_id', '=', 'rooms.id')
            ->leftJoin('users', 'bookings.user_id', '=', 'users.id')
            ->leftJoin('stay_records', 'booking_rooms.id', '=', 'stay_records.booking_room_id')
            ->select(
                'bookings.id as booking_id',
                'bookings.booking_code',
                'bookings.guest_name',
                'bookings.guest_phone',
                'users.name as tenTaiKhoan',
                'bookings.check_in_date',
                'bookings.check_out_date',
                'bookings.status as booking_status',
                'booking_rooms.id as booking_room_id',
                'booking_rooms.room_id',
                'booking_rooms.room_type_id',
                'room_types.name as room_type_name',
                'rooms.room_number',
                'rooms.status as room_status',
                'stay_records.id as stay_id',
                'stay_records.actual_check_out'
            )
            ->whereIn('bookings.status', ['confirmed', 'checked_in'])
            ->orderBy('bookings.check_in_date')
            ->get();

        $phongTrong = DB::table('rooms')
            ->where('status', 'available')
            ->orderBy('room_number')
            ->get();

        return view(
            'receptionist.stays.index',
            compact('datPhong', 'phongTrong')
        );
    }

    // Nhan phong
    public function checkIn(Request $request, $bookingRoomId)
    {
        $request->validate([
            'room_id' => 'required|integer|exists:rooms,id'
        ]);

        $nhanVienId = auth()->id();

        if (!$nhanVienId) {
            return back()->with(
                'error',
                'Vui lòng đăng nhập trước khi trả phòng.'
            );
        }

        try {
            DB::transaction(function () use (
                $request,
                $bookingRoomId,
                $nhanVienId
            ) {
                $chiTietDatPhong = DB::table('booking_rooms')
                    ->join(
                        'bookings',
                        'booking_rooms.booking_id',
                        '=',
                        'bookings.id'
                    )
                    ->where('booking_rooms.id', $bookingRoomId)
                    ->select(
                        'booking_rooms.*',
                        'bookings.status as booking_status'
                    )
                    ->lockForUpdate()
                    ->first();

                if (!$chiTietDatPhong) {
                    throw new \Exception(
                        'Khong tim thay chi tiet dat phong.'
                    );
                }

                if (!in_array(
                    $chiTietDatPhong->booking_status,
                    ['confirmed', 'checked_in']
                )) {
                    throw new \Exception(
                        'Don dat phong chua du dieu kien nhan phong.'
                    );
                }

                $luuTru = DB::table('stay_records')
                    ->where('booking_room_id', $bookingRoomId)
                    ->first();

                if ($luuTru) {
                    throw new \Exception(
                        'Phong nay da duoc lam thu tuc nhan phong.'
                    );
                }

                $phong = DB::table('rooms')
                    ->where('id', $request->room_id)
                    ->lockForUpdate()
                    ->first();

                if (!$phong) {
                    throw new \Exception(
                        'Khong tim thay phong duoc chon.'
                    );
                }

                if ($phong->status != 'available') {
                    throw new \Exception(
                        'Phong nay khong con trong.'
                    );
                }

                if (
                    $phong->room_type_id !=
                    $chiTietDatPhong->room_type_id
                ) {
                    throw new \Exception(
                        'Loai phong khong phu hop voi don dat.'
                    );
                }

                DB::table('booking_rooms')
                    ->where('id', $bookingRoomId)
                    ->update([
                        'room_id' => $request->room_id,
                        'updated_at' => now()
                    ]);

                DB::table('stay_records')->insert([
                    'booking_room_id' => $bookingRoomId,
                    'checked_in_by' => $nhanVienId,
                    'actual_check_in' => now(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);

                DB::table('rooms')
                    ->where('id', $request->room_id)
                    ->update([
                        'status' => 'occupied',
                        'updated_at' => now()
                    ]);

                $soPhongChuaNhan = DB::table('booking_rooms')
                    ->leftJoin(
                        'stay_records',
                        'booking_rooms.id',
                        '=',
                        'stay_records.booking_room_id'
                    )
                    ->where(
                        'booking_rooms.booking_id',
                        $chiTietDatPhong->booking_id
                    )
                    ->whereNull('stay_records.id')
                    ->count();

                if ($soPhongChuaNhan == 0) {
                    DB::table('bookings')
                        ->where(
                            'id',
                            $chiTietDatPhong->booking_id
                        )
                        ->update([
                            'status' => 'checked_in',
                            'updated_at' => now()
                        ]);
                }
            });

            return back()->with(
                'success',
                'Nhan phong thanh cong.'
            );
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    // Tra phong
    public function checkOut($stayId)
    {
        $nhanVienId = auth()->id();

        if (!$nhanVienId) {
            return back()->with(
                'error',
                'Vui long dang nhap truoc khi tra phong.'
            );
        }

        try {
            DB::transaction(function () use (
                $stayId,
                $nhanVienId
            ) {
                $luuTru = DB::table('stay_records')
                    ->join(
                        'booking_rooms',
                        'stay_records.booking_room_id',
                        '=',
                        'booking_rooms.id'
                    )
                    ->where('stay_records.id', $stayId)
                    ->select(
                        'stay_records.*',
                        'booking_rooms.booking_id',
                        'booking_rooms.room_id'
                    )
                    ->lockForUpdate()
                    ->first();

                if (!$luuTru) {
                    throw new \Exception(
                        'Khong tim thay thong tin luu tru.'
                    );
                }

                if ($luuTru->actual_check_out != null) {
                    throw new \Exception(
                        'Phong nay da duoc tra truoc do.'
                    );
                }

                DB::table('stay_records')
                    ->where('id', $stayId)
                    ->update([
                        'checked_out_by' => $nhanVienId,
                        'actual_check_out' => now(),
                        'updated_at' => now()
                    ]);

                DB::table('rooms')
                    ->where('id', $luuTru->room_id)
                    ->update([
                        'status' => 'cleaning',
                        'updated_at' => now()
                    ]);

                $soPhongChuaTra = DB::table('booking_rooms')
                    ->join(
                        'stay_records',
                        'booking_rooms.id',
                        '=',
                        'stay_records.booking_room_id'
                    )
                    ->where(
                        'booking_rooms.booking_id',
                        $luuTru->booking_id
                    )
                    ->whereNull('stay_records.actual_check_out')
                    ->count();

                if ($soPhongChuaTra == 0) {
                    DB::table('bookings')
                        ->where('id', $luuTru->booking_id)
                        ->update([
                            'status' => 'checked_out',
                            'updated_at' => now()
                        ]);
                }
            });

            return back()->with(
                'success',
                'Tra phong thanh cong. Phong dang cho don dep.'
            );
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
