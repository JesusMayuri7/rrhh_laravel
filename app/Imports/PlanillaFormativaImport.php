<?php

namespace App\Imports;

use App\Http\Models\PlanillaFormativa;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class PlanillaFormativaImport implements ToCollection
{
    private $mes;
    private $fuente=0;
    private $meta='0000';
    public function __construct(string $mes)
    {
        $this->mes = $mes;
    }

    public function collection(Collection $rows)
    {
      $descripcion = $rows[0][3];  
      \App\Http\Models\PlanillaFormativa::where(['mes'=>$this->mes, 'descripcion'=>$descripcion])->delete();              

        foreach ($rows as $row)
        {          
            
            if ($row[0] === 'PNMC' && $fuente == 0 ) {
                $fuente = 2; 
                $meta = $row[1];
                continue;
            }
            if ($row[0] === 'RLOC' && $fuente == 0 ) {
                $fuente = 1;
                $meta = $row[1];
                continue;
            }
            if (is_numeric($row[0]) && (strlen($row[0])==5) )
            {
                PlanillaFormativa::create([                                                              
                    "id_personal" => $row[0] ?? 0,                    
                    "nombres" => $row[1] ?? "",                
                    "dni" =>$row[2] ?? "00000000",
                    "monto" => $row[3] ?? 0,
                    "media" => $row[4] ?? 0,
                    "reintegro" => $row[5] ?? 0,
                    "total_ingreso" => $row[6] ?? 0,                    
                    "sctr_pension" => $row[7] ?? 0,
                    "sctr_salud" => $row[8] ?? 0,                    
                    "total_aporte" => $row[9] ?? 0,                                        
                    "meta" => $meta,
                    "fuente" => $fuente,
                    "mes" => $this->mes,
                    "anio" => 2022,
                    "descripcion" => $descripcion
                ]);
            }
            else
            {
               $fuente = 0;
            }
            
        }  // foreach
    } //funcion




}
