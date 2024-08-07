<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Turbi extends Model
{
    use HasFactory;
    protected $table = 'kekeruhan';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function getFormattedCreatedAtAttribute()
     {
         return Carbon::parse($this->attributes['created_at'])->format('H:i');
     }
}
