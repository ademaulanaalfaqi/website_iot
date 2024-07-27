<?php

namespace App\Http\Controllers\Jupi;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use App\Models\WaterFlow;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PelangganController extends Controller
{
    public function index()
    {
        // Menggunakan Eloquent untuk melakukan join
        $pelanggan = Pelanggan::all();

        return view('admin.jupi.pelanggan.index', compact('pelanggan'));
    }

    public function create()
    {
        return view('admin.jupi.pelanggan.create');
    }

    public function store(Request $request)
    {
        // Begin transaction
        DB::beginTransaction();
        // Buat pelanggan baru dan set id_sensor dengan id sensor yang baru dibuat            
        $randomChar = Str::random(5);
        $pelanggan = new Pelanggan();
        $pelanggan->id = 'Met-' . $randomChar;
        $pelanggan->nama = $request->input('nama');
        $pelanggan->alamat = $request->input('alamat');
        $pelanggan->latitude = $request->input('latitude');
        $pelanggan->longitude = $request->input('longitude');
        $pelanggan->keterangan = $request->input('keterangan');
        $pelanggan->sensor = 'Meteran';
        $pelanggan->save();

        // Commit transaction
        DB::commit();

        return redirect('pelanggan');
    }

    public function detail($id)
    {
        $pelanggan = Pelanggan::find($id);

        // Mengambil semua data volume dari tabel WaterFlow terkait pelanggan
        $meteran = WaterFlow::where('id_pelanggan', $id)->get();

        // Hitung total volume
        $totalVolume = $meteran->sum('volume');

        // Tarif per liter
        $tarifPerLiter = 3; // Misalnya 3 IDR per liter

        // Menghitung total biaya
        $totalBiaya = $totalVolume * $tarifPerLiter;

        return view('admin.jupi.pelanggan.detail', compact('pelanggan', 'totalBiaya'));
    }

    public function edit($id)
    {
        $pelanggan = Pelanggan::find($id);
        $sensor = $pelanggan->sensor;

        return view('admin.jupi.pelanggan.edit', compact('pelanggan', 'sensor'));
    }

    public function update(Request $request, $id)
    {
        // Begin transaction
        DB::beginTransaction();

        // Update data pelanggan
        $pelanggan = Pelanggan::find($id);
        $pelanggan->nama = $request->input('nama');
        $pelanggan->alamat = $request->input('alamat');
        $pelanggan->latitude = $request->input('latitude');
        $pelanggan->longitude = $request->input('longitude');
        $pelanggan->keterangan = $request->input('keterangan');
        $pelanggan->sensor = 'Meteran';
        $pelanggan->save();

        // Commit transaction
        DB::commit();

        return redirect('pelanggan');
    }

    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan deleted successfully.');
    }

    // public function chartMeter()
    // {
    //     // Mengambil data volume dari model WaterFlow
    //     $volumedata = WaterFlow::orderBy('id', 'desc')->take(24)->get();

    //     // Memformat data untuk respon JSON
    //     $formattedData = $volumedata->map(function ($data) {
    //         return [
    //             'volume' => $data->volume,
    //             'created_at' => $data->created_at->format('H:i:s') // Format waktu
    //         ];
    //     });

    //     return response()->json($formattedData);
    // }

    public function chartMeter()
    {
        // Ambil data dari database
        $data = WaterFlow::all();

        // Proses data menggunakan foreach
        foreach ($data as &$entry) {
            // Misalnya menambahkan field baru 'processed' pada setiap entry
            $entry['processed'] = true;
        }

        return response()->json($data);
    }

    // Metode baru untuk menampilkan data volume dan menghitung biaya
    public function meteran($id)
    {
        // Ambil semua data volume dari tabel water_flows berdasarkan id_pelanggan
        $meteran = WaterFlow::where('id_pelanggan', $id)->take(24)->get();

        // Hitung total volume
        $totalVolume = $meteran->sum('volume');

        // Tarif per liter
        $tarifPerLiter = 3; // Misalnya 3 IDR per liter

        // Menghitung total biaya
        $totalBiaya = $totalVolume * $tarifPerLiter;

        // Ambil data pelanggan
        $pelanggan = Pelanggan::all(); // atau sesuaikan dengan kebutuhan Anda

        return view('admin.jupi.index', compact('meteran', 'totalVolume', 'totalBiaya', 'id', 'pelanggan'));
    }
}
