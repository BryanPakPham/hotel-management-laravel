<?php

namespace App\Http\Controllers\Receptionist;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ServiceController extends Controller
{
    public function index()
    {
        $dichVu = DB::table('services')
            ->orderBy('name')
            ->get();

        $luuTru = DB::table('stay_records')
            ->join(
                'booking_rooms',
                'stay_records.booking_room_id',
                '=',
                'booking_rooms.id'
            )
            ->join(
                'bookings',
                'booking_rooms.booking_id',
                '=',
                'bookings.id'
            )
            ->join(
                'rooms',
                'booking_rooms.room_id',
                '=',
                'rooms.id'
            )
            ->whereNull('stay_records.actual_check_out')
            ->select(
                'stay_records.id as stay_id',
                'bookings.booking_code',
                'bookings.guest_name',
                'bookings.guest_phone',
                'rooms.room_number'
            )
            ->orderBy('rooms.room_number')
            ->get();

        $daSuDung = DB::table('booking_services')
            ->join(
                'stay_records',
                'booking_services.stay_record_id',
                '=',
                'stay_records.id'
            )
            ->join(
                'services',
                'booking_services.service_id',
                '=',
                'services.id'
            )
            ->join(
                'booking_rooms',
                'stay_records.booking_room_id',
                '=',
                'booking_rooms.id'
            )
            ->join(
                'bookings',
                'booking_rooms.booking_id',
                '=',
                'bookings.id'
            )
            ->join(
                'rooms',
                'booking_rooms.room_id',
                '=',
                'rooms.id'
            )
            ->select(
                'booking_services.id',
                'booking_services.quantity',
                'booking_services.unit_price',
                'booking_services.total_price',
                'booking_services.used_at',
                'services.name as tenDichVu',
                'services.unit',
                'bookings.guest_name',
                'bookings.booking_code',
                'rooms.room_number'
            )
            ->orderByDesc('booking_services.used_at')
            ->get();

        return view(
            'receptionist.services.index',
            compact('dichVu', 'luuTru', 'daSuDung')
        );
    }

    // Ghi nhan dich vu khach su dung
    public function store(Request $request)
    {
        $request->validate([
            'stay_record_id' => 'required|integer|exists:stay_records,id',
            'service_id' => 'required|integer|exists:services,id',
            'quantity' => 'required|integer|min:1|max:1000'
        ]);

        $nhanVienId = auth()->id();

        if (!$nhanVienId) {
            return back()->with(
                'error',
                'Vui lòng đăng nhập trước khi ghi nhận dịch vụ.'
            );
        }

        try {
            DB::transaction(function () use (
                $request,
                $nhanVienId
            ) {
                $luuTru = DB::table('stay_records')
                    ->where('id', $request->stay_record_id)
                    ->lockForUpdate()
                    ->first();

                if (
                    !$luuTru ||
                    $luuTru->actual_check_out != null
                ) {
                    throw new \Exception(
                        'Khach khong con dang luu tru.'
                    );
                }

                $dichVu = DB::table('services')
                    ->where('id', $request->service_id)
                    ->where('is_active', 1)
                    ->first();

                if (!$dichVu) {
                    throw new \Exception(
                        'Dich vu khong ton tai hoac da ngung hoat dong.'
                    );
                }

                $soLuong = (int) $request->quantity;
                $donGia = $dichVu->price;
                $thanhTien = $soLuong * $donGia;

                DB::table('booking_services')->insert([
                    'stay_record_id' => $luuTru->id,
                    'service_id' => $dichVu->id,
                    'added_by' => $nhanVienId,
                    'quantity' => $soLuong,
                    'unit_price' => $donGia,
                    'total_price' => $thanhTien,
                    'used_at' => now(),
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            });

            return redirect()
                ->route('receptionist.services.index')
                ->with(
                    'success',
                    'Ghi nhan dich vu thanh cong.'
                );
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
