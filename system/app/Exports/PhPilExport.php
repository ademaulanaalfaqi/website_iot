<?php

namespace App\Exports;

use App\Models\Ph;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class PhPilExport implements FromCollection ,WithHeadings, WithMapping
{
    protected $ph;
    protected $startDate;
    protected $endDate;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($ph, $startDate = null, $endDate = null)
    {
        $this->ph = $ph;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }
    public function collection()
    {
        $query = Ph::where('id_sensor', $this->ph);

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        return $query->orderBy('id', 'desc')
                     ->get(['id_sensor', 'ph_value', 'ph_voltage', 'created_at']);
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
