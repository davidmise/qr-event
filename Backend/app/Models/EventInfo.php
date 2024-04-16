<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class EventInfo extends Model
{
    use HasApiTokens, HasFactory, Notifiable;
    protected $fillable = [
        'event_name',
        'event_subtitle',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
    ];
}
