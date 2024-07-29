<?php

namespace App\Http\Controllers;

use App\Models\Ph;
use App\Models\Sensor;
use App\Models\Turbi;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    function beranda()
    {
        $data['sensors'] = Sensor::with(['debit', 'tekanan'])->get();
        $data['ph'] = Ph::where('id_sensor', 'pH-kGK')->latest()->value('ph_value');
        $data['turbi'] = Turbi::where('id_sensor', 'Tur-0FU')->latest()->value('turbi_ntu');
        // dd($data['ph']);
        return view('admin.beranda', $data);
    }

    public function getDataParaSensor()
    {
        $sensors = Sensor::with(['debit' => function ($query) {
            $query->latest()->first();
        }, 'tekanan' => function ($query) {
            $query->latest()->first();
        }])->get();
        return response()->json($sensors);
    }
}
