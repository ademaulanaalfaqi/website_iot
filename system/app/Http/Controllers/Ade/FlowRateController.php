<?php

namespace App\Http\Controllers\Ade;

use App\Http\Controllers\Controller;
use App\Models\FlowRate;
use Illuminate\Http\Request;

class FlowRateController extends Controller
{
    public function flowPressure()
    {
        // Mendapatkan 5 data terbaru kelembapan dari model atau query
        $dataHumidity = FlowRate::orderByDesc('id')->take(5)->pluck('flow_rate')->toArray();
        $humidityData = array_reverse($dataHumidity);

        // Mendapatkan 5 waktu terbaru dari model atau query
        $labels = FlowRate::latest()->take(5)->pluck('created_at')->map(function ($item) {
            return $item->format('H.i.s'); // Sesuaikan format sesuai kebutuhan Anda
        })->toArray();
        $labels = array_reverse($labels);

        // menampilkan angka debit
        $flow = FlowRate::orderByDesc('id')->pluck('flow_rate')->first();
        // dd($flow);


        return view('admin.ade.index', ['humidityData' => $humidityData, 'labels' => $labels, 'flow' => $flow]);
    }

    public function getBilanganDebit() {
        $debit = FlowRate::orderByDesc('id')->pluck('flow_rate')->take(1)->toArray();
        return response()->json(['debit' => $debit]);
    }

    // untuk update data chart
    public function chartDebit()
    {
        // Mendapatkan data kelembapan dari model atau query
        $dataHumidity = FlowRate::orderByDesc('id')->take(5)->pluck('flow_rate')->toArray();
        $humidityData = array_reverse($dataHumidity);
        
        // Mendapatkan waktu terbaru dari model atau query
        $labels = FlowRate::latest()->take(5)->pluck('created_at')->map(function ($item) {
            return $item->format('H.i.s'); // Sesuaikan format sesuai kebutuhan Anda
        })->toArray();
        $labels = array_reverse($labels);


        return response()->json(['humidityData' => $humidityData, 'labels' => $labels]);
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
}
