<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Amenity extends Model
{
    protected $table = 'amenities';

    protected $fillable = [
        'name',
        'description',
        'icon',
    ];

    public function roomTypes(): BelongsToMany
    {
        return $this->belongsToMany(
            RoomType::class,
            'amenity_room_type',
            'amenity_id',
            'room_type_id'
        );
    }
}
