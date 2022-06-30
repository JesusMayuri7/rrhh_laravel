<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use App\Http\Models\Orden;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Maatwebsite\Excel\Concerns\ToModel;

class OrdenesSigaMefExport extends DefaultValueBinder implements FromCollection,WithHeadings,ShouldAutoSize
{
    //use Exportable;   

    public function collection()
    {
        return Orden::select('centro_costo',
        'nombre_depend',
        'orden',
        'nro_pedido',
        'fecha_orden',
        'nro_ruc',
        'nombre_prov',
        'valor',
        'dsc_orden',
        'plazos',
        'inicio',
        'fin',
        'estados',
        'control',
        'vigencia',
        'tipo')->get();
    } 

    public function headings(): array
    {
        return [
            'centro_costo',
            'nombre_depend',
            'orden',
            'nro_pedido',
            'fecha_orden',
            'nro_ruc',
            'nombre_prov',
            'valor',
            'dsc_orden',
            'plazos',
            'inicio',
            'fin',
            'estados',
            'control',
            'vigencia',
            'tipo'          
        ];
    }


    public function columnFormats(): array
    {
        return [
            'centro_costo'  => StringFormat::FORMAT_GENERAL,
            'nombre_depend'  => StringFormat::FORMAT_GENERAL,
            'orden'  => StringFormat::FORMAT_GENERAL,
            'nro_pedido'  => StringFormat::FORMAT_GENERAL,
            'fecha_orden'  => StringFormat::FORMAT_GENERAL,
            'nro_ruc'  => NumberFormat::FORMAT_GENERAL,
            'nombre_prov'  => NumberFormat::FORMAT_GENERAL,
            'valor'  => StringFormat::FORMAT_GENERAL,
            'dsc_orden'  => NumberFormat::FORMAT_GENERAL,
            'plazos'  => StringFormat::FORMAT_GENERAL,
            'inicio'  => StringFormat::FORMAT_GENERAL,
            'fin'  => StringFormat::FORMAT_GENERAL,
            'estados'  => StringFormat::FORMAT_GENERAL,
            'control'  => StringFormat::FORMAT_GENERAL,
            'vigencia' => StringFormat::FORMAT_GENERAL,
        ];
    }

    public function title(): string
    {
        return 'PERSONAL CON CONTRATO VIGENTE ';
    }

    /*
    public function array(): array
    {
        $data= DB::select(DB::raw("SELECT * FROM rpt_cap_ocupados"));
        return $data;
    }*/
}