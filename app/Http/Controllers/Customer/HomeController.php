<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\BookingRoom;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $validated = $request->validate([
            'destination' => ['nullable', 'string', 'max:40'],
            'checkin' => ['nullable', 'date', 'after_or_equal:today'],
            'checkout' => ['nullable', 'date', 'after:checkin'],
            'adults' => ['nullable', 'integer', 'min:1', 'max:20'],
            'children' => ['nullable', 'integer', 'min:0', 'max:20'],
            'rooms' => ['nullable', 'integer', 'min:1', 'max:4'],
        ]);

        if ($request->filled('checkin') && $request->filled('checkout')) {
            return redirect()->route('rooms.index', [
                'checkin' => Carbon::parse($validated['checkin'])->toDateString(),
                'checkout' => Carbon::parse($validated['checkout'])->toDateString(),
                'adults' => $validated['adults'] ?? 2,
                'children' => $validated['children'] ?? 0,
                'rooms' => $validated['rooms'] ?? 1,
                'destination' => $validated['destination'] ?? 'nha-trang',
            ]);
        }

        $roomTypes = RoomType::query()
            ->with(['images' => fn ($query) => $query->orderByDesc('is_primary')->orderBy('sort_order')])
            ->withCount('rooms')
            ->orderBy('base_price')
            ->get();
        $roomTypes->each(function ($roomType) {
            $roomType->setRelation(
                'images',
                $roomType->images
                    ->filter(fn ($image) => Storage::disk('public')->exists($image->path))
                    ->values()
            );
        });

        return view('customer.home', compact('roomTypes'));
    }

    public function highlights()
    {
        $bookingCounts = BookingRoom::query()
            ->whereHas('booking', fn ($query) => $query->whereNotIn('status', ['cancelled']))
            ->selectRaw('room_type_id, COUNT(*) as bookings_count')
            ->groupBy('room_type_id')
            ->pluck('bookings_count', 'room_type_id');

        $roomTypes = RoomType::query()
            ->with(['images' => fn ($query) => $query->orderByDesc('is_primary')->orderBy('sort_order'), 'amenities'])
            ->get()
            ->each(function ($roomType) use ($bookingCounts) {
                $roomType->bookings_count = (int) ($bookingCounts[$roomType->id] ?? 0);
                $roomType->setRelation(
                    'images',
                    $roomType->images
                        ->filter(fn ($image) => Storage::disk('public')->exists($image->path))
                        ->values()
                );
            })
            ->sortByDesc('bookings_count')
            ->values();

        $featuredRoomType = $roomTypes->first();

        return view('customer.highlights', compact('featuredRoomType', 'roomTypes'));
    }
}
