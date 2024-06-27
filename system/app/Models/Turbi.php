<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Turbi extends Model
{
    use HasFactory;
    protected $table = 'data_turbi';
    protected $primaryKey = 'id';

    public function getFormattedCreatedAtAttribute()
     {
         return Carbon::parse($this->attributes['timestamp'])->format('H:i');
     }
}
