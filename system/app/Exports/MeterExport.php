<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\WaterFlow;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class MeterExport implements FromCollection, WithHeadings, WithMapping
{
    protected $id;
    protected $exportDate;

    public function __construct($id, $exportDate)
    {
        $this->id = $id;
        $this->exportDate = $exportDate;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return WaterFlow::where('id_pelanggan', $this->id)
            ->whereDate('created_at', $this->exportDate)
            ->with('pelanggans') // Ambil relasi pelanggan
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID Pelanggan',
            'Nama',
            'Sensor',
            'Volume',
            'Tanggal'
        ];
    }

    public function map($row): array
    {
        return [
            $row->id_pelanggan,
            $row->pelanggans->nama, // Ambil nama dari relasi pelanggan
            $row->pelanggans->sensor, // Ambil sensor dari relasi pelanggan
            $row->volume,
            Carbon::parse($row->created_at)->format('Y-m-d H:i:s')
        ];
    }
}