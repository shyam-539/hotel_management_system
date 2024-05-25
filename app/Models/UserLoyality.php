<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserLoyality extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'loyalty_id',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function loyalty()
    {
        return $this->belongsTo(Loyality::class,'loyalty_id');
    }
}
