<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextOverlay extends Model
{
    use HasFactory;
    protected $fillable = [
        'identifier',
        'x',
        'y',
        'font_size',
        'font_family',
        'font_color',
        'event_info_id'
    ];
}
