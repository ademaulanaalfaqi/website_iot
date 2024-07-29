<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pelanggan extends Model
{
    use HasFactory;
    
    protected $table = 'pelanggans';
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $fillable = ['nama', 'alamat', 'latitude', 'longitude', 'keterangan', 'sensor', 'volume'];

    public function WaterFlow()
    {
        return $this->belongsTo(WaterFlow::class, 'id');
    }

}