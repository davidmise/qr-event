<?php
// app/Models/Template.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    use HasFactory;

    protected $fillable = [
        'identifier',
        'template',
    ];

    public function overlays()
    {
        return $this->hasMany(TextOverlay::class, 'identifier', 'identifier');
    }
}
