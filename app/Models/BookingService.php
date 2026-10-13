<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookingService extends Model
{
    protected $table = 'booking_services';

    protected $fillable = [
        'stay_record_id',
        'service_id',
        'added_by',
        'quantity',
        'unit_price',
        'total_price',
        'used_at',
    ];

    protected function casts(): array
    {
        return [
            'quantity' => 'integer',
            'unit_price' => 'decimal:2',
            'total_price' => 'decimal:2',
            'used_at' => 'datetime',
        ];
    }

    public function stayRecord(): BelongsTo
    {
        return $this->belongsTo(StayRecord::class, 'stay_record_id');
    }

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}