<?php

namespace App\Http\Controllers\Ari;

use App\Models\Ph;
use Carbon\Carbon;
use App\Models\Sensor;
use App\Exports\PhExport;
use App\Exports\PhPilExport;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Response;

class PhController extends Controller
{
    public function ph()
    {
        $data['sensor_ph'] = Sensor::where('sensor', 'pH')->get();
        foreach ($data['sensor_ph'] as $sensor) {
            $sensor->ph_value = Ph::where('id_sensor', $sensor->id)->latest()->first()->ph_value ?? 'N/A';
            $sensor->ph_voltage = Ph::where('id_sensor', $sensor->id)->latest()->first()->ph_voltage ?? 'N/A';
        }
        return view('admin.ari.ph.index', $data);
    }

    public function detailSensorPh($ph)
    {
        $data['sensorph'] = Sensor::find($ph);
        $data['historyLaporan'] = Ph::where('id_sensor', $ph)->orderBy('id', 'desc')->get();

        return view('admin.ari.ph.detail', $data);
    }

    public function menambahkanSensorPh()
    {
        $randomChar = Str::random(3);

        $sensorph = new Sensor();
        $sensorph->id = 'pH-' . $randomChar;
        $sensorph->latitude = request('latitude');
        $sensorph->longitude = request('longitude');
        $sensorph->keterangan = request('keterangan');
        $sensorph->sensor = 'pH';
        $sensorph->save();

        return redirect('ph');
    }

    public function updateSensorPh(Sensor $ph)
    {
        $ph->latitude = request('latitude');
        $ph->longitude = request('longitude');
        $ph->keterangan = request('keterangan');
        $ph->save();

        return redirect('ph');
    }

    public function hapusSensorPh(Sensor $ph)
    {
        $ph->delete();

        return redirect('ph');
    }
    public function apiPh()
    {
        $sensor_ph = Sensor::where('sensor', 'pH')->get();

        $data = $sensor_ph->map(function ($sensor) {
            return [
                'id' => $sensor->id,
                'value' => Ph::where('id_sensor', $sensor->id)->latest()->first()->ph_value ?? 'N/A',
                'voltage' => Ph::where('id_sensor', $sensor->id)->latest()->first()->ph_voltage ?? 'N/A',
            ];
        });

        return response()->json($data);
    }

    public function apiChartPh($id)
    {
        $phdata = Ph::where('id_sensor', $id)->orderBy('id', 'desc')->take(24)->get();

        $formattedData = $phdata->map(function ($data) {
            return [
                'ph_value' => $data->ph_value,
                'created_at' => $data->formatted_created_at
            ];
        });

        return response()->json($formattedData);
    }

    public function apiLastPh($id)
    {
        $phlast = Ph::where('id_sensor', $id)->orderBy('id', 'desc')->pluck('ph_value')->first();

        if (is_null($phlast)) {
            return response()->json([
                'status' => 'error',
                'message' => 'No data available'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'ph_value' => $phlast
            ]
        ]);
    }

    public function downloadTodayReportPh($ph)
    {
        $date = Carbon::now()->format('Y-m-d');
        $fileName = $ph . '_' . $date . '.xlsx';
        return Excel::download(new PhExport($ph), $fileName);

    }

    public function downloadReportsPh(Request $request, $ph)
    {
        $request->validate([
            'startDate' => 'required|date',
            'endDate' => 'required|date',
        ]);

        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $fileName = $ph . '_' . $startDate . ' hingga ' . $endDate . '.xlsx';

        return Excel::download(new PhPilExport($ph, $startDate, $endDate), $fileName);

    }
}
