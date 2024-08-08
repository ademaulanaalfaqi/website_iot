<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Turbi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TurbiPilExport implements FromCollection, WithHeadings, WithMapping
{
    protected $turbi;
    protected $startDate;
    protected $endDate;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct($turbi, $startDate = null, $endDate = null)
    {
        $this->turbi = $turbi;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }
    public function collection()
    {
        $query = Turbi::where('id_sensor', $this->turbi);

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        }

        return $query->orderBy('id', 'desc')
                     ->get(['id_sensor', 'turbi_ntu', 'turbi_voltage', 'created_at']);
    }
    public function headings(): array
    {
        return [
            'Sensor ID',
            'Nilai turbi',
            'Voltage turbi',
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
