<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
class DashboardController extends Controller
{
    public function index()
    {
        // Thống kê phòng
        $totalRooms = DB::table('rooms')->count();

        $availableRooms = DB::table('rooms')
            ->where('status', 'available')
            ->count();

        $occupiedRooms = DB::table('rooms')
            ->where('status', 'occupied')
            ->count();

        $maintenanceRooms = DB::table('rooms')
            ->whereIn('status', ['cleaning', 'maintenance'])
            ->count();

        // Thống kê đặt phòng
        $totalBookings = DB::table('bookings')->count();

        $pendingBookings = DB::table('bookings')
            ->where('status', 'pending')
            ->count();

        // Thống kê khách hàng
        $totalCustomers = DB::table('users')
            ->where('role', 'customer')
            ->count();

        // 5 đơn đặt phòng mới nhất
        $recentBookings = DB::table('bookings')
            ->select(
                'id',
                'booking_code',
                'guest_name',
                'guest_phone',
                'check_in_date',
                'check_out_date',
                'status',
                'total_amount',
                'created_at'
            )
            ->orderByDesc('created_at')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalRooms',
            'availableRooms',
            'occupiedRooms',
            'maintenanceRooms',
            'totalBookings',
            'pendingBookings',
            'totalCustomers',
            'recentBookings'
        ));
    }
}