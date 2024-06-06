<?php

namespace App\Http\Controllers\Ade;

use App\Models\FlowRate;
use App\Models\Pressure;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FlowPressureController extends Controller
{
    public function flowPressure()
    {
        return view('admin.ade.index');
    }

    public function apiChartFlow()
    {
        $flowdata = FlowRate::orderBy('id', 'desc')->take(7)->get();

        // format created_at
        $formattedData = $flowdata->map(function ($data) {
            return [
                'flow_rate' => $data->flow_rate,
                'created_at' => $data->formatted_created_at // Menggunakan accessor
            ];
        });

        return response()->json($formattedData);
    }

    public function apiTextFlow()
    {
        $flowtext = FlowRate::orderBy('id', 'desc')->pluck('flow_rate')->first();
        return response()->json($flowtext);
    }

    public function apiChartPressure()
    {
        $pressuredata = Pressure::orderBy('id', 'desc')->take(7)->get();

        // format created_at
        $formattedData = $pressuredata->map(function ($data) {
            return [
                'pressure_rate' => $data->pressure_rate,
                'created_at' => $data->formatted_created_at // Menggunakan accessor
            ];
        });

        return response()->json($formattedData);
    }

    public function apiTextPressure()
    {
        $pressuretext = Pressure::orderBy('id', 'desc')->pluck('pressure_rate')->first();
        return response()->json($pressuretext);
    }
}
