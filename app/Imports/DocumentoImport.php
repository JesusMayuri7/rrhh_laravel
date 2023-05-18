<?php

namespace App\Imports;

use App\Http\Models\Documentos;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DocumentoImport implements ToCollection,WithStartRow
{
    private $anio;
    private $rowsImported;
    public function __construct(string $anio)
    {
        $this->anio = $anio;
        $this->rowsImported=0;
        Documentos::where(['anio'=>$this->anio, 'control'=>'INTERNO'])->delete();              
    }

    public function collection(Collection $rows)
    {
        
        foreach ($rows as $row)
        {    
            ++$this->rowsImported;
            if(substr($row[1],0,2) == 'I-' || substr($row[1],0,2) == 'E-')                  
            Documentos::create([                                                              
                    "expediente_pvn" => $row[1] ?? "",                    
                    "numero_pvn" => $row[2] ?? "",                    
                    "asunto" => $row[3] ?? "",                    
                    "remite" => $row[7] ?? "",                
                    "estado" => "PENDIENTE",
                    "fecha_derivacion" => Carbon::createFromFormat('d/m/Y', $row[13])->format('Y-m-d'),
                    //"fecha" => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[3])),
                    "anio" => $this->anio,
                    "tipo"=> "OTROS",
                    "control"=> "INTERNO"
                ]);
        }
    } 
    
    public function startRow(): int
    {
        return 3;
    }

    public function getRowCount(): int
    {
        return $this->rowsImported;
    } 
} //funcion





