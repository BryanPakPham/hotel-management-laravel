<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * Danh sách đặt phòng.
     */
    public function index(Request $request)
    {
        $query = DB::table('bookings');

        // Tìm theo mã đặt phòng, tên khách hoặc số điện thoại.
        if ($request->filled('keyword')) {
            $keyword = trim($request->keyword);

            $query->where(function ($q) use ($keyword) {
                $q->where('booking_code', 'like', "%{$keyword}%")
                    ->orWhere('guest_name', 'like', "%{$keyword}%")
                    ->orWhere('guest_phone', 'like', "%{$keyword}%");
            });
        }

        // Lọc theo trạng thái.
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Lọc theo ngày nhận phòng.
        if ($request->filled('check_in_date')) {
            $query->where('check_in_date', '>=', $request->check_in_date);
        }

        if ($request->filled('check_in_date_to')) {
            $query->where('check_in_date', '<=', $request->check_in_date_to);
        }

        $bookings = $query
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        // Thống kê tổng quan theo toàn bộ đơn đặt phòng.
        $totalBookings = DB::table('bookings')->count();

        $pendingBookings = DB::table('bookings')
            ->where('status', 'pending')
            ->count();

        $confirmedBookings = DB::table('bookings')
            ->where('status', 'confirmed')
            ->count();

        $checkedInBookings = DB::table('bookings')
            ->where('status', 'checked_in')
            ->count();

        return view('admin.bookings.index', compact(
            'bookings',
            'totalBookings',
            'pendingBookings',
            'confirmedBookings',
            'checkedInBookings'
        ));
    }

    /**
     * Xem chi tiết một đơn đặt phòng.
     */
    public function show(string $id)
    {
        $booking = DB::table('bookings')
            ->where('id', $id)
            ->first();

        if (!$booking) {
            abort(404);
        }

        // Lấy danh sách loại phòng và phòng được gán cho đơn đặt.
        $bookingRooms = DB::table('booking_rooms')
            ->leftJoin(
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
            ->where('booking_rooms.booking_id', $id)
            ->select(
                'booking_rooms.*',
                'room_types.name as room_type_name',
                'rooms.room_number'
            )
            ->get();

        return view('admin.bookings.show', compact(
            'booking',
            'bookingRooms'
        ));
    }
    public function confirm(string $id)
    {
        $booking = DB::table('bookings')->where('id', $id)->first();

        if (!$booking) {
            abort(404);
        }

        if ($booking->status !== 'pending') {
            return redirect()
                ->route('admin.bookings.show', $id)
                ->with('error', 'Chỉ có thể xác nhận đơn đang chờ xử lý.');
        }

        DB::table('bookings')
            ->where('id', $id)
            ->where('status', 'pending')
            ->update([
                'status' => 'confirmed',
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('admin.bookings.show', $id)
            ->with('success', 'Xác nhận đặt phòng thành công.');
    }

    public function cancel(Request $request, string $id)
    {
        $request->validate([
            'cancel_reason' => ['required', 'string', 'max:1000'],
        ], [
            'cancel_reason.required' => 'Vui lòng nhập lý do hủy đặt phòng.',
            'cancel_reason.max' => 'Lý do hủy không được vượt quá 1000 ký tự.',
        ]);

        $booking = DB::table('bookings')->where('id', $id)->first();

        if (!$booking) {
            abort(404);
        }

        if (!in_array($booking->status, ['pending', 'confirmed'], true)) {
            return redirect()
                ->route('admin.bookings.show', $id)
                ->with('error', 'Không thể hủy đơn ở trạng thái hiện tại.');
        }

        DB::table('bookings')
            ->where('id', $id)
            ->whereIn('status', ['pending', 'confirmed'])
            ->update([
                'status' => 'cancelled',
                'cancel_reason' => $request->cancel_reason,
                'cancelled_at' => now(),
                'updated_at' => now(),
            ]);

        return redirect()
            ->route('admin.bookings.show', $id)
            ->with('success', 'Hủy đặt phòng thành công.');
    }
}
