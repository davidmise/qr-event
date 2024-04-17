<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'guest_attendance_id',
    ];

    public function attendances()
    {
        return $this->hasMany(GuestAttendance::class);
    }
}
