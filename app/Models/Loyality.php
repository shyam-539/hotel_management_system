<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loyality extends Model
{
    use HasFactory;

    protected  $fillable = [
        'programme_name',
        'points',
        
    ];

    public function userLoyalties()
    {
        return $this->hasMany(UserLoyality::class);
    }
}
