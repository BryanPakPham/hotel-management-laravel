<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\RoomType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $bookings = $request->user()->bookings()
            ->with(['bookingRooms.roomType', 'bookingRooms.room'])
            ->latest()
            ->paginate(8);

        return view('customer.bookings.index', compact('bookings'));
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'room_type_id' => ['required', 'integer', 'exists:room_types,id'],
            'checkin' => ['required', 'date', 'after_or_equal:today'],
            'checkout' => ['required', 'date', 'after:checkin'],
            'adults' => ['required', 'integer', 'min:1', 'max:20'],
            'children' => ['nullable', 'integer', 'min:0', 'max:20'],
        ]);

        $roomType = RoomType::with('amenities')->findOrFail($validated['room_type_id']);
        if (
            $validated['adults'] > $roomType->max_adults
            || ($validated['children'] ?? 0) > $roomType->max_children
        ) {
            return redirect()->route('rooms.index', $validated)
                ->withErrors(['room_type_id' => 'Loại phòng này không đủ sức chứa cho số khách đã chọn.']);
        }

        $availableRooms = $roomType->rooms()
            ->where('status', 'available')
            ->whereDoesntHave('bookingRooms.booking', function ($booking) use ($validated) {
                $booking->whereNotIn('status', ['cancelled', 'completed'])
                    ->whereDate('check_in_date', '<', $validated['checkout'])
                    ->whereDate('check_out_date', '>', $validated['checkin']);
            })
            ->get();

        if ($availableRooms->isEmpty()) {
            return redirect()->route('rooms.index', $validated)
                ->withErrors(['room_type_id' => 'Loại phòng này không còn phòng trong khoảng thời gian đã chọn.']);
        }

        return view('customer.bookings.create', compact('roomType', 'availableRooms', 'validated'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_type_id' => ['required', 'integer', 'exists:room_types,id'],
            'checkin' => ['required', 'date', 'after_or_equal:today'],
            'checkout' => ['required', 'date', 'after:checkin'],
            'adults' => ['required', 'integer', 'min:1', 'max:20'],
            'children' => ['nullable', 'integer', 'min:0', 'max:20'],
            'guest_name' => ['required', 'string', 'max:120'],
            'guest_phone' => ['required', 'string', 'max:30'],
            'guest_email' => ['required', 'email', 'max:120'],
            'note' => ['nullable', 'string', 'max:500'],
        ]);

        $booking = DB::transaction(function () use ($request, $validated) {
            $roomType = RoomType::findOrFail($validated['room_type_id']);
            if (
                $validated['adults'] > $roomType->max_adults
                || ($validated['children'] ?? 0) > $roomType->max_children
            ) {
                throw ValidationException::withMessages([
                    'room_type_id' => 'Loại phòng này không đủ sức chứa cho số khách đã chọn.',
                ]);
            }

            $room = $roomType->rooms()
                ->where('status', 'available')
                ->whereDoesntHave('bookingRooms.booking', function ($booking) use ($validated) {
                    $booking->whereNotIn('status', ['cancelled', 'completed'])
                        ->whereDate('check_in_date', '<', $validated['checkout'])
                        ->whereDate('check_out_date', '>', $validated['checkin']);
                })
                ->lockForUpdate()
                ->first();

            if (! $room) {
                abort(409, 'Phòng vừa được đặt bởi khách khác. Vui lòng chọn thời gian khác.');
            }

            $nights = Carbon::parse($validated['checkin'])->diffInDays(Carbon::parse($validated['checkout']));
            $total = $nights * (float) $roomType->base_price;

            $booking = Booking::create([
                'booking_code' => 'BK-'.Str::upper(Str::random(8)),
                'user_id' => $request->user()->id,
                'guest_name' => $validated['guest_name'],
                'guest_phone' => $validated['guest_phone'],
                'guest_email' => $validated['guest_email'],
                'note' => $validated['note'] ?? null,
                'check_in_date' => $validated['checkin'],
                'check_out_date' => $validated['checkout'],
                'num_adults' => $validated['adults'],
                'num_children' => $validated['children'] ?? 0,
                'status' => 'pending',
                'total_amount' => $total,
            ]);

            $booking->bookingRooms()->create([
                'room_type_id' => $roomType->id,
                'room_id' => $room->id,
                'price_per_night' => $roomType->base_price,
            ]);

            return $booking;
        });

        return redirect()->route('customer.bookings.show', $booking)
            ->with('success', 'Đặt phòng thành công. Mã đặt phòng của bạn là '.$booking->booking_code.'.');
    }

    public function show(Request $request, Booking $booking)
    {
        abort_unless($booking->getAttribute('user_id') === $request->user()->id, 403);
        $booking->load(['bookingRooms.roomType.amenities', 'bookingRooms.room']);

        return view('customer.bookings.show', compact('booking'));
    }

    public function cancel(Request $request, Booking $booking): RedirectResponse
    {
        abort_unless($booking->getAttribute('user_id') === $request->user()->id, Response::HTTP_FORBIDDEN);

        if (! \in_array($booking->getAttribute('status'), ['pending', 'confirmed'], true)) {
            return back()->withErrors(['booking' => 'Đặt phòng này không thể hủy ở trạng thái hiện tại.']);
        }

        if ($booking->check_in_date->toDateString() <= Carbon::today()->toDateString()) {
            return back()->withErrors(['booking' => 'Không thể hủy đặt phòng sau ngày nhận phòng.']);
        }

        $booking->update([
            'status' => 'cancelled',
            'cancelled_at' => now(),
            'cancel_reason' => 'Khách hàng hủy đặt phòng.',
        ]);

        return redirect()->route('customer.bookings.show', $booking)
            ->with('success', 'Đặt phòng đã được hủy thành công.');
    }
}
