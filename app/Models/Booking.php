<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Booking extends Model
{
    protected $table = 'bookings';

    protected $fillable = [
        'booking_code',
        'user_id',
        'created_by',
        'guest_name',
        'guest_phone',
        'guest_email',
        'note',
        'check_in_date',
        'check_out_date',
        'adults',
        'children',
        'status',
        'total_amount',
        'deposit_amount',
        'cancellation_reason',
        'cancelled_at',
    ];

    protected function casts(): array
    {
        return [
            'check_in_date' => 'date',
            'check_out_date' => 'date',
            'cancelled_at' => 'datetime',
            'adults' => 'integer',
            'children' => 'integer',
            'total_amount' => 'decimal:2',
            'deposit_amount' => 'decimal:2',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function bookingRooms(): HasMany
    {
        return $this->hasMany(BookingRoom::class, 'booking_id');
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class, 'booking_id');
    }
}
