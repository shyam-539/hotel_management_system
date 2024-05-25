<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Room extends Model
{
    use HasFactory;
    protected $fillable = [
        'lookuproom_id',
        'room_number',
        'room_count',
        'price',
        'description',
        'room_size',
    ];

    /**
     * Get the room type for the room.
     */
    public function roomType()
    {
        return $this->belongsTo(LookupRoom::class, 'lookuproom_id');
    }
     /**
     * The facilities that belong to the room.
     */
    public function facilities()
    {
        return $this->belongsToMany(LookupFacility::class, 'facility_room', 'room_id', 'facility_id');
    }

    /**
     * The beds that belong to the room.
     */
    public function beds()
    {
        return $this->belongsToMany(Bed::class, 'bed_room', 'room_id', 'bed_id');
    }

     /**
     * Get the images for the room.
     */
    public function images()
    {
        return $this->hasMany(RoomImage::class);
    }

    public static function getTableName()
    {
        return with(new static)->getTable();
    }
}
