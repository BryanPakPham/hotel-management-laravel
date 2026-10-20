<?php

namespace Database\Seeders;

use App\Models\Amenity;
use App\Models\Room;
use App\Models\RoomType;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::updateOrCreate(['email' => 'test@example.com'], [
            'name' => 'Test User',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'is_active' => true,
        ]);

        User::updateOrCreate(['email' => 'customer@example.com'], [
            'name' => 'Khách hàng mẫu',
            'phone' => '0901234567',
            'password' => Hash::make('password'),
            'role' => 'customer',
            'is_active' => true,
        ]);

        $amenities = collect([
            ['name' => 'Wi-Fi miễn phí', 'icon' => 'bi bi-wifi'],
            ['name' => 'Điều hòa', 'icon' => 'bi bi-snow'],
            ['name' => 'Bữa sáng', 'icon' => 'bi bi-cup-hot'],
            ['name' => 'TV thông minh', 'icon' => 'bi bi-tv'],
            ['name' => 'Minibar', 'icon' => 'bi bi-cup-straw'],
            ['name' => 'Ban công riêng', 'icon' => 'bi bi-door-open'],
        ])->mapWithKeys(function (array $amenity) {
            $model = Amenity::updateOrCreate(['name' => $amenity['name']], $amenity);

            return [$model->name => $model];
        });

        $roomTypes = [
            [
                'name' => 'Deluxe Ocean View',
                'description' => 'Phòng nghỉ thanh lịch với tầm nhìn hướng biển, phù hợp cho kỳ nghỉ thư giãn.',
                'base_price' => 1850000,
                'max_adults' => 2,
                'max_children' => 1,
                'bed_type' => '1 giường đôi lớn',
                'area' => 42,
                'amenities' => ['Wi-Fi miễn phí', 'Điều hòa', 'Bữa sáng', 'TV thông minh'],
                'rooms' => ['101', '102'],
            ],
            [
                'name' => 'Premier Garden View',
                'description' => 'Không gian rộng rãi, yên tĩnh với khung cảnh khu vườn xanh mát.',
                'base_price' => 2350000,
                'max_adults' => 2,
                'max_children' => 2,
                'bed_type' => '1 giường king',
                'area' => 55,
                'amenities' => ['Wi-Fi miễn phí', 'Điều hòa', 'Bữa sáng', 'Minibar'],
                'rooms' => ['201', '202'],
            ],
            [
                'name' => 'Family Suite',
                'description' => 'Suite tiện nghi dành cho gia đình, có không gian sinh hoạt thoải mái.',
                'base_price' => 3200000,
                'max_adults' => 4,
                'max_children' => 2,
                'bed_type' => '2 giường đôi',
                'area' => 78,
                'amenities' => ['Wi-Fi miễn phí', 'Điều hòa', 'Bữa sáng', 'TV thông minh', 'Ban công riêng'],
                'rooms' => ['301', '302'],
            ],
        ];

        foreach ($roomTypes as $roomTypeData) {
            $roomType = RoomType::updateOrCreate(
                ['slug' => Str::slug($roomTypeData['name'])],
                collect($roomTypeData)->except(['amenities', 'rooms'])->all()
            );

            $roomType->amenities()->sync(
                collect($roomTypeData['amenities'])
                    ->map(fn (string $name) => $amenities[$name]->id)
                    ->all()
            );

            foreach ($roomTypeData['rooms'] as $roomNumber) {
                Room::updateOrCreate(
                    ['room_number' => $roomNumber],
                    [
                        'room_type_id' => $roomType->id,
                        'floor' => (int) substr($roomNumber, 0, 1),
                        'status' => 'available',
                    ]
                );
            }
        }
    }
}
