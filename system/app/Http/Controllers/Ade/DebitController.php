<?php

namespace App\Http\Controllers\Ade;

use Carbon\Carbon;
use App\Models\Sensor;
use App\Models\FlowRate;
use Illuminate\Support\Str;
use App\Exports\DebitExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

class DebitController extends Controller
{
    public function debit()
    {
            $data['sensor_debit'] = Sensor::where('sensor', 'Debit')->get();
            foreach ($data['sensor_debit'] as $sensor) {
                $sensor->debit = FlowRate::where('id_sensor', $sensor->id)->latest()->first()->nilai_debit ?? 'N/A';
                $sensor->total_liter = FlowRate::where('id_sensor', $sensor->id)->latest()->first()->total_liter ?? 'N/A';
            }
        return view('admin.ade.debit.index', $data);
    }

    public function tambahSensorDebit()
    {
        return view('admin.ade.debit.tambah_sensor');
    }

    function tambahkanSensorDebit()
    {
        $randomChar = Str::random(5);

        $sensordebit = new Sensor();
        $sensordebit->id = 'Deb-' . $randomChar;
        $sensordebit->latitude = request('latitude');
        $sensordebit->longitude = request('longitude');
        $sensordebit->keterangan = request('keterangan');
        $sensordebit->sensor = 'Debit';
        $sensordebit->save();

        return redirect('debit');
    }

    function detailSensorDebit($id)
    {
        $data['sensordebit'] = Sensor::find($id);
        // dd($data['datadebit']);
        return view('admin.ade.debit.detail', $data);
    }

    function editSensorDebit($id)
    {
        $data['sensordebit'] = Sensor::find($id);
        // dd($data['datadebit']);
        return view('admin.ade.debit.edit', $data);
    }

    function updateSensorDebit(Sensor $id)
    {
        $id->latitude = request('latitude');
        $id->longitude = request('longitude');
        $id->keterangan = request('keterangan');
        $id->save();

        return redirect('debit');
    }

    function hapusSensorDebit(Sensor $id)
    {
        $id->delete();

        return redirect('debit');
    }

    function exportDataSensorDebit(Request $request, $id)
    {
        $request->validate([
            'export_date' => 'required|date',
        ]);

        $exportDate = $request->input('export_date');
        $fileName = $id . '_' . $exportDate . '.xlsx';

        return Excel::download(new DebitExport($id, $exportDate), $fileName);
    }

    public function apiChartFlow($id)
    {
        $flowdata = FlowRate::where('id_sensor', $id)->orderBy('id', 'desc')->take(24)->get();

        // format created_at
        $formattedData = $flowdata->map(function ($data) {
            return [
                'nilai_debit' => $data->nilai_debit,
                'total_liter' => $data->total_liter,
                'created_at' => $data->formatted_created_at // Menggunakan accessor
            ];
        });

        return response()->json($formattedData);
    }

    public function apiTextFlow($id)
    {
        $flowtext = FlowRate::where('id_sensor', $id)->orderBy('id', 'desc')->select('nilai_debit', 'total_liter')->first();

        if ($flowtext) {
            return response()->json([
                'nilai_debit' => $flowtext->nilai_debit,
                'total_liter' => $flowtext->total_liter,
            ]);
        } else {
            return response()->json([
                'nilai_debit' => null,
                'total_liter' => null,
            ]);
        }
    }

    public function apiDebit()
    {
        $sensor_debit = Sensor::where('sensor', 'Debit')->get();

        $data = $sensor_debit->map(function($sensor) {
            return [
                'id' => $sensor->id,
                'debit' => FlowRate::where('id_sensor', $sensor->id)->latest()->first()->nilai_debit ?? 'N/A',
                'total_liter' => FlowRate::where('id_sensor', $sensor->id)->latest()->first()->total_liter ?? 'N/A',
            ];
        });

        return response()->json($data);
    }
}
