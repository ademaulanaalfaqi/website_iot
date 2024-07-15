<?php

namespace App\Models;

use App\Models\FlowRate;
use App\Models\Pressure;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sensor extends Model
{
    use HasFactory;
    protected $table = 'sensor';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    protected $fillable = ['id', 'latitude', 'longitude', 'keterangan', 'sensor'];

    function debit()
    {
        return $this->hasMany(FlowRate::class, 'id_sensor');
    }

    function tekanan()
    {
        return $this->hasMany(Pressure::class, 'id_sensor');
    }
}
