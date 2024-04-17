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
        'location_id',
        'organizer_id',
        'ticket_id',
        'media_id'
    ];

    public function location()
    {
        return $this->hasOne(Location::class);
    }

    public function organizer()
    {
        return $this->hasOne(Organizer::class);
    }

    public function socialLink()
    {
        return $this->hasOne(SocialLink::class);
    }

    public function ticket()
    {
        return $this->hasOne(Ticket::class);
    }
    public function media()
    {
        return $this->hasOne(Media::class);
    }


}
