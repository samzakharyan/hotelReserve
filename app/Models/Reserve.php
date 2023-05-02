<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserve extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'days', 'room_id'];

    public function room()
    {
        return $this->hasOne(Room::class);
    }
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function rooms()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
}
