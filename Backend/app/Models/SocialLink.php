<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SocialLink extends Model
{
    // Set the table name (optional)
    // protected $table = 'social_links';

    // Fillable fields
    protected $fillable = [
        'instagram',
        'facebook',
        'website',
        'event_info_id'
    ];
    public function event_info(){
        return $this->hasOne(EventInfo::class);
    }
}
