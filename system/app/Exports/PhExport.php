<?php

namespace App\Exports;

use App\Models\Ph;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PhExport implements FromCollection, WithHeadings, WithMapping
{
    protected $ph;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($ph)
    {
        $this->ph = $ph;
    }
    public function collection()
    {
        return Ph::where('id_sensor', $this->ph)
        ->orderBy('id', 'desc')->take(24)
        ->get(['id_sensor', 'ph_value','ph_voltage', 'created_at']);
    }
    public function headings(): array
    {
        return [
            'Sensor ID',
            'Nilai pH',
            'Voltage pH',
            'Waktu'
        ];
    }
    public function map($row): array
    {
        return [
            $row->id_sensor,
            $row->ph_value,
            $row->ph_voltage,
            Carbon::parse($row->created_at)->format('Y-m-d H:i:s')
        ];
    }
}
