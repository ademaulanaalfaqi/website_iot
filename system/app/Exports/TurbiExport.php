<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Turbi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TurbiExport implements FromCollection, WithHeadings, WithMapping
{
    protected $turbi;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($turbi)
    {
        $this->turbi = $turbi;
    }
    public function collection()
    {
        return Turbi::where('id_sensor', $this->turbi)
        ->orderBy('id', 'desc')->take(24)
        ->get(['id_sensor', 'turbi_ntu','turbi_voltage', 'created_at']);
    }
    public function headings(): array
    {
        return [
            'Sensor ID',
            'Nilai Turbi',
            'Voltage Turbi',
            'Waktu'
        ];
    }
    public function map($row): array
    {
        return [
            $row->id_sensor,
            $row->turbi_ntu,
            $row->turbi_voltage,
            Carbon::parse($row->created_at)->format('Y-m-d H:i:s')
        ];
    }
}
