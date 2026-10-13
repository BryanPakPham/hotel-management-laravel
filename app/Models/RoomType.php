<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class RoomType extends Model
{
    protected $table = 'room_types';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'base_price',
        'max_adults',
        'max_children',
        'bed_type',
        'area',
    ];

    protected function casts(): array
    {
        return [
            'base_price' => 'decimal:2',
            'area' => 'decimal:2',
            'max_adults' => 'integer',
            'max_children' => 'integer',
        ];
    }

    public function rooms(): HasMany
    {
        return $this->hasMany(Room::class, 'room_type_id');
    }

    public function images(): HasMany
    {
        return $this->hasMany(RoomImage::class, 'room_type_id');
    }

    public function amenities(): BelongsToMany
    {
        return $this->belongsToMany(
            Amenity::class,
            'amenity_room_type',
            'room_type_id',
            'amenity_id'
        );
    }
}
?>
