<?php

namespace App\Exports;

use Carbon\Carbon;
use App\Models\Pressure;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TekananExport implements FromCollection, WithHeadings, WithMapping
{
    protected $id;
    protected $exportDate;

    public function __construct($id, $exportDate)
    {
        $this->id = $id;
        $this->exportDate = $exportDate;    
    }

    public function collection()
    {
        return Pressure::where('id_sensor', $this->id)
                        ->whereDate('created_at', $this->exportDate)
                       ->get(['id_sensor', 'nilai_tekanan', 'created_at']);
    }

    public function headings(): array
    {
        return [
            'Sensor ID',
            'Nilai Tekanan',
            'Waktu'
        ];
    }

    public function map($row): array
    {
        return [
            $row->id_sensor,
            $row->nilai_tekanan,
            Carbon::parse($row->created_at)->format('Y-m-d H:i:s')
        ];
    }
}
