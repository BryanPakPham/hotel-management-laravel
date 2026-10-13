<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StayRecord extends Model
{
    protected $table = 'stay_records';

    protected $fillable = [
        'booking_room_id',
        'checked_in_by',
        'checked_out_by',
        'actual_check_in',
        'actual_check_out',
        'status',
        'note',
    ];

    protected function casts(): array
    {
        return [
            'actual_check_in' => 'datetime',
            'actual_check_out' => 'datetime',
            'booking_room_id' => 'integer',
            'checked_in_by' => 'integer',
            'checked_out_by' => 'integer',
        ];
    }

    public function bookingRoom(): BelongsTo
    {
        return $this->belongsTo(
            BookingRoom::class,
            'booking_room_id'
        );
    }

    public function checkedInBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checked_in_by');
    }

    public function checkedOutBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'checked_out_by');
    }
}