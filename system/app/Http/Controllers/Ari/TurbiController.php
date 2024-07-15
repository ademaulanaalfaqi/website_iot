<?php

namespace App\Http\Controllers\Ari;

use Carbon\Carbon;
use App\Models\Turbi;
use App\Models\Sensor;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class TurbiController extends Controller
{
    public function turbi()
    {
        $data['sensor_turbi'] = Sensor::where('sensor', 'Turbidity')->get();
        foreach ($data['sensor_turbi'] as $sensor) {
            $sensor->turbi_voltage = Turbi::where('id_sensor', $sensor->id)->latest()->first()->turbi_voltage ?? 'N/A';
            $sensor->turbi_ntu = Turbi::where('id_sensor', $sensor->id)->latest()->first()->turbi_ntu ?? 'N/A';
        }
        return view('admin.ari.turbi.index', $data);
    }

    public function detailSensorTurbi($turbi)
    {
        $data['sensorturbi'] = Sensor::find($turbi);
        // $historyLaporan = Turbi::where('id_sensor', $turbi)->get();
        $data['historyLaporan'] = Turbi::where('id_sensor', $turbi)->get();

        // // Kelompokkan data berdasarkan tanggal
        // $groupedHistoryLaporan = $historyLaporan->groupBy(function ($date) {
        //     return \Carbon\Carbon::parse($date->created_at)->format('Y-m-d');
        // });

        // $data['historyLaporan'] = $groupedHistoryLaporan;

        return view('admin.ari.turbi.detail', $data);
    }

    public function menambahkanSensorTurbi()
    {
        $randomChar = Str::random(3);

        $sensorturbi = new Sensor();
        $sensorturbi->id = 'Tur-' . $randomChar;
        $sensorturbi->latitude = request('latitude');
        $sensorturbi->longitude = request('longitude');
        $sensorturbi->keterangan = request('keterangan');
        $sensorturbi->sensor = 'Turbidity';
        $sensorturbi->save();

        return redirect('kekeruhan');
    }

    public function updateSensorTurbi(Sensor $turbi)
    {
        $turbi->latitude = request('latitude');
        $turbi->longitude = request('longitude');
        $turbi->keterangan = request('keterangan');
        $turbi->save();

        return redirect('kekeruhan');
    }

    public function hapusSensorTurbi(Sensor $turbi)
    {
        $turbi->delete();

        return redirect('kekeruhan');
    }
    public function apiTurbi()
    {
        $sensor_turbi = Sensor::where('sensor', 'Turbidity')->get();

        $data = $sensor_turbi->map(function ($sensor) {
            return [
                'id' => $sensor->id,
                'ntu' => Turbi::where('id_sensor', $sensor->id)->latest()->first()->turbi_ntu ?? 'N/A',
                'voltage' => Turbi::where('id_sensor', $sensor->id)->latest()->first()->turbi_voltage ?? 'N/A',
            ];
        });

        return response()->json($data);
    }

    public function apiChartTurbi($id)
    {
        $turbidata = Turbi::where('id_sensor', $id)->orderBy('id', 'desc')->take(24)->get();

        $formattedData = $turbidata->map(function ($data) {
            return [
                'turbi_ntu' => $data->turbi_ntu,
                'turbi_voltage' => $data->turbi_voltage,
                'created_at' => $data->formatted_created_at
            ];
        });

        return response()->json($formattedData);
    }

    public function apiLastTurbi($id)
    {
        $turbilast = Turbi::where('id_sensor', $id)->orderBy('id', 'desc')->pluck('turbi_ntu')->first();

        if (is_null($turbilast)) {
            return response()->json([
                'status' => 'error',
                'message' => 'No data available'
            ], 404);
        }

        return response()->json([
            'turbi_ntu' => $turbilast
        ]);
    }

    public function downloadTodayReportTurbi($turbi)
    {
        $todayReports = Turbi::where('id_sensor', $turbi)->orderBy('id', 'desc')->take(24)->get();

        $csvData = "Id Sensor,Tanggal Laporan,Nilai NTU\n";
        foreach ($todayReports as $report) {
            $csvData .= "{$report->id_sensor},{$report->created_at},{$report->turbi_ntu}\n";
        }

        $fileName = 'laporan_turbidity_hari_ini.csv';
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => "attachment; filename={$fileName}",
        ];

        return Response::make($csvData, 200, $headers);
    }

    // public function downloadReportsTurbi(Request $request)
    // {
    //     $ids = explode(',', $request->query('ids'));
    //     $reports = Turbi::whereIn('id', $ids)->get();

    //     if ($reports->isEmpty()) {
    //         return redirect()->back()->with('error', 'Laporan tidak ditemukan.');
    //     }

    //     $csvData = "Id Sensor,Tanggal Laporan,Nilai NTU\n";
    //     foreach ($reports as $report) {
    //         $csvData .= "{$report->id_sensor},{$report->created_at},{$report->turbi_ntu}\n";
    //     }

    //     $date = Carbon::parse($reports->first()->created_at)->format('Y-m-d');
    //     $fileName = count($reports) > 1 ? "laporan_turbidity_{$date}.csv" : "laporan_turbidity_{$date}.csv";
    //     $headers = [
    //         'Content-type' => 'text/csv',
    //         'Content-Disposition' => "attachment; filename={$fileName}",
    //     ];

    //     return Response::make($csvData, 200, $headers);
    // }
}
