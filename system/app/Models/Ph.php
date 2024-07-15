<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ph extends Model
{
    use HasFactory;
    protected $table = 'ph';
    protected $primaryKey = 'id';

    public function getFormattedCreatedAtAttribute()
     {
         return Carbon::parse($this->attributes['created_at'])->format('H:i');
     }

}
