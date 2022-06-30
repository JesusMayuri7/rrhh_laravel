<?php

namespace App\Exports;

use App\Http\Models\Presupuesto;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromArray;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class PresupuestoExport implements FromArray,WithHeadings,
WithColumnFormatting,
WithTitle,
WithStrictNullComparison
{
    //use Exportable; 
    private $mes;
    public function forMes(int $mes = 1)
    {
        $this->mes = $mes;
        return $this;
    }

    public function headings(): array
    {
        return [
            'fuente',
            'actividad',
            'idactividad',
            'especifica',
            'detalle',
            'pim',
            'Total',
            'Saldo',
            'enero',
            'febrero',
            'marzo',
            'abril',
            'mayo',
            'junio',
            'julio',
            'agosto',
            'setiembre',
            'octubre',
            'noviembre',
            'diciembre',
            'proyeccion',
            'analisis'
        ];
    }

    public function columnFormats(): array
    {

        return [
            'fuente'  => NumberFormat::FORMAT_GENERAL,
            'actividad'  => NumberFormat::FORMAT_GENERAL,
            'idactividad'  => NumberFormat::FORMAT_GENERAL,
            'especifica'  => NumberFormat::FORMAT_GENERAL,
            'detalle'  => NumberFormat::FORMAT_GENERAL,
            'pim'  => NumberFormat::FORMAT_GENERAL,
            'Total'  => NumberFormat::FORMAT_GENERAL,
            'Saldo'  => NumberFormat::FORMAT_GENERAL,
            'enero'  => NumberFormat::FORMAT_GENERAL,
            'febrero'  => NumberFormat::FORMAT_GENERAL,
            'marzo'  => NumberFormat::FORMAT_GENERAL,
            'abril'  => NumberFormat::FORMAT_GENERAL,
            'mayo'  => NumberFormat::FORMAT_GENERAL,
            'junio'  => NumberFormat::FORMAT_GENERAL,
            'julio'  => NumberFormat::FORMAT_GENERAL,
            'agosto'  => NumberFormat::FORMAT_GENERAL,
            'setiembre'  => NumberFormat::FORMAT_GENERAL,
            'octubre'  => NumberFormat::FORMAT_GENERAL,
            'noviembre'  => NumberFormat::FORMAT_GENERAL,
            'diciembre'  => NumberFormat::FORMAT_GENERAL,
            'proyeccion' => NumberFormat::FORMAT_GENERAL,
            'analisis'  => NumberFormat::FORMAT_GENERAL
        ];
    }

    public function title(): string
    {
        return 'Proyeccion';
    }

    public function array(): array
    {
        $data= DB::select(DB::raw("CALL sp_proyeccion_presupuestal_cap(:mes)"),['mes'=>$this->mes]);
        return $data;
    }
}