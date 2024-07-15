<?php

namespace App\Http\Controllers\Ari;

use App\Models\Ph;
use Carbon\Carbon;
use App\Models\Sensor;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
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
        // $historyLaporan = Ph::where('id_sensor', $ph)->get();
        $data['historyLaporan'] = Ph::where('id_sensor', $ph)->get();

        // Kelompokkan data berdasarkan tanggal
        // $groupedHistoryLaporan = $historyLaporan->groupBy(function ($date) {
        //     return \Carbon\Carbon::parse($date->created_at)->format('Y-m-d');
        // });

        // $data['historyLaporan'] = $groupedHistoryLaporan;

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
        $todayReports = Ph::where('id_sensor',$ph)->orderBy('id', 'desc')->take(24)->get();

        $csvData = "Id Sensor,Tanggal Laporan,Nilai Ph\n";
        foreach ($todayReports as $report) {
            $csvData .= "{$report->id_sensor},{$report->created_at},{$report->ph_value}\n";
        }

        $fileName = 'laporan_pH_hari_ini.csv';
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ];

        return Response::make($csvData, 200, $headers);
    }

    // public function downloadReportsPh(Request $request)
    // {
    //     $ids = explode(',', $request->query('ids'));
    //     $reports = Ph::whereIn('id', $ids)->get();

    //     if ($reports->isEmpty()) {
    //         return redirect()->back()->with('error', 'Laporan tidak ditemukan.');
    //     }

    //     $csvData = "Id Sensor,Tanggal Laporan,Nilai pH\n";
    //     foreach ($reports as $report) {
    //         $csvData .= "{$report->id_sensor},{$report->created_at},{$report->ph_value}\n";
    //     }

    //     $date = Carbon::parse($reports->first()->created_at)->format('Y-m-d');
    //     $fileName = count($reports) > 1 ? "laporan_ph_{$date}.csv" : "laporan_ph_{$date}.csv";
    //     $headers = [
    //         'Content-type' => 'text/csv',
    //         'Content-Disposition' => "attachment; filename={$fileName}",
    //     ];

    //     return Response::make($csvData, 200, $headers);
    // }
}
