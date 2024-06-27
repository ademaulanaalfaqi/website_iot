<?php

namespace App\Http\Controllers\Ari;

use App\Models\Turbi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class QualityController extends Controller
{
    public function turbi()
    {
        return view('admin.ari.index');
    }

    public function apiChartTurbi()
    {
        $turbidata = Turbi::orderBy('id', 'desc')->take(7)->get();

        $formattedData = $turbidata->map(function ($data) {
            return [
                'ntu_value' => $data->ntu_value,
                'turbi_value' => $data->turbi_value,
                'turbi_voltage' => $data->turbi_voltage,
                'timestamp' => \Carbon\Carbon::parse($data->timestamp)->format('H:i')
            ];
        });

        return response()->json($formattedData);
    }

    public function apiLastTurbi()
    {
        $turbitext = Turbi::orderBy('id', 'desc')->pluck('ntu_value')->first();
        return response()->json($turbitext);
    }
}
