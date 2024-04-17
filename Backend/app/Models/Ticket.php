<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $fillable = [
        'price',
        'event_capacity',
        'event_info_id'
    ];
    public function event_info(){
        return $this->hasOne(EventInfo::class);
    }
}
