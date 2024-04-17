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
    ];

    // No need for explicit casting as fillable fields are assumed to be strings
}
