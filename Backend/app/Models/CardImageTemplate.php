<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardImageTemplate extends Model
{
    use HasFactory;

    protected $fillable = ['name','path','event_info_id'];
    
    public function event(){
        return $this->belongsTo(EventInfo::class);
    }
}
