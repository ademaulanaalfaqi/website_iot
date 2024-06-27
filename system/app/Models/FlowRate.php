<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FlowRate extends Model
{
    use HasFactory;
    protected $table = 'debit';
    protected $primaryKey = 'id';

     // Accessor
     public function getFormattedCreatedAtAttribute()
     {
         return Carbon::parse($this->attributes['created_at'])->format('H:i');
     }
}
