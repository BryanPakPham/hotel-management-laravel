<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class BookingRoom extends Model
{
    protected $table = 'booking_rooms';

    protected $fillable = [
        'booking_id',
        'room_type_id',
        'room_id',
        'price_per_night',
    ];

    protected function casts(): array
    {
        return [
            'booking_id' => 'integer',
            'room_type_id' => 'integer',
            'room_id' => 'integer',
            'price_per_night' => 'decimal:2',
        ];
    }

    public function booking(): BelongsTo
    {
        return $this->belongsTo(Booking::class, 'booking_id');
    }

    public function roomType(): BelongsTo
    {
        return $this->belongsTo(RoomType::class, 'room_type_id');
    }

    public function room(): BelongsTo
    {
        return $this->belongsTo(Room::class, 'room_id');
    }

    public function stayRecord(): HasOne
    {
        return $this->hasOne(StayRecord::class, 'booking_room_id');
    }
}
