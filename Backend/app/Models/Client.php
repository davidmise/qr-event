<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Clients extends Model
{
    use HasFactory,HasFactory, Notifiable;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'event_type',
        'cost',
        'event_capacity'
    ];

    public function event(){
        return $this->hasOne(EventInfo::class);
    }
}
