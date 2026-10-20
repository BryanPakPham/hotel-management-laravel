<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\RoomType;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class RoomController extends Controller
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

        $checkin = $validated['checkin'] ?? Carbon::today()->toDateString();
        $checkout = $validated['checkout'] ?? Carbon::tomorrow()->toDateString();
        $adultsRequested = $validated['adults'] ?? 2;
        $childrenRequested = $validated['children'] ?? 0;
        $roomsRequested = $validated['rooms'] ?? 1;

        $roomTypes = RoomType::query()
            ->with([
                'images' => fn ($query) => $query->orderByDesc('is_primary')->orderBy('sort_order'),
                'amenities',
            ])
            ->where('max_adults', '>=', $adultsRequested)
            ->where('max_children', '>=', $childrenRequested)
            ->whereHas('rooms', function ($query) use ($checkin, $checkout) {
                $query->where('status', 'available')
                    ->whereDoesntHave('bookingRooms.booking', function ($booking) use ($checkin, $checkout) {
                        $booking->whereNotIn('status', ['cancelled', 'completed'])
                            ->whereDate('check_in_date', '<', $checkout)
                            ->whereDate('check_out_date', '>', $checkin);
                    });
            })
            ->whereHas('rooms', function ($query) use ($checkin, $checkout) {
                $query->where('status', 'available')
                    ->whereDoesntHave('bookingRooms.booking', function ($booking) use ($checkin, $checkout) {
                        $booking->whereNotIn('status', ['cancelled', 'completed'])
                            ->whereDate('check_in_date', '<', $checkout)
                            ->whereDate('check_out_date', '>', $checkin);
                    });
            }, '>=', $roomsRequested)
            ->withCount(['rooms as available_rooms_count' => function ($query) use ($checkin, $checkout) {
                $query->where('status', 'available')
                    ->whereDoesntHave('bookingRooms.booking', function ($booking) use ($checkin, $checkout) {
                        $booking->whereNotIn('status', ['cancelled', 'completed'])
                            ->whereDate('check_in_date', '<', $checkout)
                            ->whereDate('check_out_date', '>', $checkin);
                    });
            }])
            ->orderBy('base_price')
            ->paginate(9)
            ->withQueryString();
        $roomTypes->getCollection()->each(function ($roomType) {
            $roomType->setRelation(
                'images',
                $roomType->images
                    ->filter(fn ($image) => Storage::disk('public')->exists($image->path))
                    ->values()
            );
        });

        return view('customer.rooms.index', compact('roomTypes', 'checkin', 'checkout'));
    }

    public function show(Request $request, RoomType $roomType)
    {
        $validated = $request->validate([
            'checkin' => ['nullable', 'date', 'after_or_equal:today'],
            'checkout' => ['nullable', 'date', 'after:checkin'],
        ]);

        $checkin = $validated['checkin'] ?? Carbon::today()->toDateString();
        $checkout = $validated['checkout'] ?? Carbon::tomorrow()->toDateString();

        $roomType->load([
            'images' => fn ($query) => $query->orderByDesc('is_primary')->orderBy('sort_order'),
            'amenities',
            'rooms' => fn ($query) => $query->where('status', 'available')
                ->whereDoesntHave('bookingRooms.booking', function ($booking) use ($checkin, $checkout) {
                    $booking->whereNotIn('status', ['cancelled', 'completed'])
                        ->whereDate('check_in_date', '<', $checkout)
                        ->whereDate('check_out_date', '>', $checkin);
                }),
        ]);
        $roomType->setRelation(
            'images',
            $roomType->images
                ->filter(fn ($image) => Storage::disk('public')->exists($image->path))
                ->values()
        );

        $nearbyPlaces = [
            [
                'icon' => 'bi-cup-hot',
                'title' => 'Bữa sáng tại nhà hàng',
                'description' => 'Thưởng thức buffet sáng với món Việt, món Á và cà phê freshly brewed trong không gian thoáng mát.',
            ],
            [
                'icon' => 'bi-egg-fried',
                'title' => 'Ẩm thực địa phương',
                'description' => 'Khám phá các món đặc sản địa phương, hải sản tươi và những quán ăn được khách lưu trú yêu thích.',
            ],
            [
                'icon' => 'bi-water',
                'title' => 'Khu hồ bơi & thư giãn',
                'description' => 'Dành thời gian thư giãn bên hồ bơi, đọc sách hoặc thưởng thức đồ uống mát lạnh sau một ngày khám phá.',
            ],
            [
                'icon' => 'bi-geo-alt',
                'title' => 'Điểm tham quan lân cận',
                'description' => 'Thuận tiện di chuyển đến các điểm tham quan, khu vui chơi, trung tâm mua sắm và địa điểm check-in nổi bật.',
            ],
        ];

        $roomServices = [
            ['icon' => 'bi-wifi', 'label' => 'Wi-Fi tốc độ cao miễn phí'],
            ['icon' => 'bi-snow', 'label' => 'Điều hòa hai chiều'],
            ['icon' => 'bi-shield-check', 'label' => 'Dọn phòng hằng ngày'],
            ['icon' => 'bi-clock', 'label' => 'Lễ tân hỗ trợ 24/7'],
            ['icon' => 'bi-car-front', 'label' => 'Hỗ trợ đặt xe và tour'],
            ['icon' => 'bi-credit-card', 'label' => 'Thanh toán thuận tiện'],
        ];

        $policies = [
            ['title' => 'Nhận phòng', 'description' => 'Từ 14:00. Vui lòng mang theo giấy tờ tùy thân khi nhận phòng.'],
            ['title' => 'Trả phòng', 'description' => 'Trước 12:00. Có thể hỏi lễ tân về dịch vụ trả phòng muộn.'],
            ['title' => 'Trẻ em', 'description' => 'Sức chứa trẻ em được tính theo thông tin của loại phòng và số lượng đã chọn.'],
            ['title' => 'Hủy phòng', 'description' => 'Chính sách hủy và thay đổi ngày ở được áp dụng theo từng đơn đặt phòng.'],
        ];

        return view('customer.rooms.show', compact(
            'roomType',
            'checkin',
            'checkout',
            'nearbyPlaces',
            'roomServices',
            'policies'
        ));
    }
}
