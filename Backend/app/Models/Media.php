<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;

     // Fillable fields
     protected $fillable = [
        'event_info_id',
        'poster',
        'banner',
        'logo',
    ];
    public function event_info(){
        return $this->hasOne(EventInfo::class);
    }
}
