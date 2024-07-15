<?php

namespace App\Http\Controllers;

use App\Models\Sensor;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    function beranda()
    {
        $data['sensors'] = Sensor::with(['debit', 'tekanan'])->get();
        // dd($sensors);

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
