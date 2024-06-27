<?php

namespace App\Http\Controllers\Ade;

use App\Models\Sensor;
use App\Models\Pressure;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TekananController extends Controller
{
    public function tekanan()
    {
        $data['sensor_tekanan'] = Sensor::where('sensor', 'Tekanan')->get();
        foreach ($data['sensor_tekanan'] as $sensor) {
            $sensor->tekanan = Pressure::where('id_sensor', $sensor->id)->latest()->first()->nilai_tekanan ?? 'N/A';
        }
        return view('admin.ade.tekanan.index', $data);
    }

    public function tambahSensorTekanan()
    {
        return view('admin.ade.tekanan.tambah_sensor');
    }

    function tambahkanSensorTekanan()
    {
        $randomChar = Str::random(5);

        $sensortekanan = new Sensor();
        $sensortekanan->id = 'Tek-' . $randomChar;
        $sensortekanan->latitude = request('latitude');
        $sensortekanan->longitude = request('longitude');
        $sensortekanan->keterangan = request('keterangan');
        $sensortekanan->sensor = 'Tekanan';
        $sensortekanan->save();

        return redirect('tekanan');
    }

    function detailSensorTekanan($id)
    {
        $data['sensortekanan'] = Sensor::find($id);
        
        return view('admin.ade.tekanan.detail', $data);
    }

    function editSensorTekanan($id)
    {
        $data['sensortekanan'] = Sensor::find($id);
        
        return view('admin.ade.tekanan.edit', $data);
    }

    function updateSensorTekanan(Sensor $id)
    {
        $id->latitude = request('latitude');
        $id->longitude = request('longitude');
        $id->keterangan = request('keterangan');
        $id->save();

        return redirect('tekanan');
    }

    function hapusSensorTekanan(Sensor $id)
    {
        $id->delete();

        return redirect('tekanan');
    }

    public function apiChartPressure($id)
    {
        $pressuredata = Pressure::where('id_sensor', $id)->orderBy('id', 'desc')->take(24)->get();

        // format created_at
        $formattedData = $pressuredata->map(function ($data) {
            return [
                'nilai_tekanan' => $data->nilai_tekanan,
                'created_at' => $data->formatted_created_at // Menggunakan accessor
            ];
        });

        return response()->json($formattedData);
    }

    public function apiTextPressure($id)
    {
        $pressuretext = Pressure::where('id_sensor', $id)->orderBy('id', 'desc')->select('nilai_tekanan')->first();

        if ($pressuretext) {
            return response()->json([
                'nilai_tekanan' => $pressuretext->nilai_tekanan,
            ]);
        } else {
            return response()->json([
                'nilai_tekanan' => null
            ]);
        }
    }

    public function apiTekanan()
    {
        $sensor_tekanan = Sensor::where('sensor', 'Tekanan')->get();

        $data = $sensor_tekanan->map(function($sensor) {
            return [
                'id' => $sensor->id,
                'tekanan' => Pressure::where('id_sensor', $sensor->id)->latest()->first()->nilai_tekanan ?? 'N/A',
            ];
        });

        return response()->json($data);
    }
}
