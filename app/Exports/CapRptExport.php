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
use App\Http\Models\CapRpt;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use Maatwebsite\Excel\Concerns\ToModel;

class CapRptExport extends DefaultValueBinder implements FromCollection,WithHeadings,ShouldAutoSize
{
    //use Exportable;   

    public function collection()
    {
        return CapRpt::all();
    } 

    public function headings(): array
    {
        return [
            'cap',
            'nombres',
            'dni',
            'ubicacion',
            'modalidad',
            'inicio',
            'fin',
            'cargo',
            'monto',
            'meta',
            'fuente'            
        ];
    }


    public function columnFormats(): array
    {
        return [
            'cao'  => StringFormat::FORMAT_GENERAL,
            'nombres'  => StringFormat::FORMAT_GENERAL,
            'dni'  => StringFormat::FORMAT_GENERAL,
            'ubicacion'  => StringFormat::FORMAT_GENERAL,
            'modalidad'  => StringFormat::FORMAT_GENERAL,
            'inicio'  => NumberFormat::FORMAT_GENERAL,
            'fin'  => NumberFormat::FORMAT_GENERAL,
            'cargo'  => StringFormat::FORMAT_GENERAL,
            'monto'  => NumberFormat::FORMAT_GENERAL,
            'meta'  => StringFormat::FORMAT_GENERAL,
            'fuente'  => StringFormat::FORMAT_GENERAL            
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