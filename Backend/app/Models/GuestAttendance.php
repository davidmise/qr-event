<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GuestAttendance extends Model
{
    use HasFactory;

    protected $fillable = [
        // 'guest_id',
        'info',
        'created_on',
        'data_expires',
        'status',
    ];

    public function guest()
    {
        return $this->belongsTo(Guest::class);
    }
}
