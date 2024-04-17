<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
    protected $fillable = [
        'city',
        'country',
        'street',
        'postal_code',
        'google_map_url',
        'event_info_id'
    ];

    public function event_info(){
        return $this->hasOne(EventInfo::class, 'event_info_id');
    }
}
