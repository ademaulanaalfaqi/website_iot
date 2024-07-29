<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WaterFlow extends Model
{
    use HasFactory;
    protected $table = 'water_flows';
    protected $fillable = ['id, volume'];

    public function getFormattedCreatedAtAttribute()
    {
        return Carbon::parse($this->attributes['timestamp'])->format('H:i');
    }

    public function Pelanggans()
    {
        return $this->belongsTo(Pelanggan::class, 'id_pelanggan');
    }
}