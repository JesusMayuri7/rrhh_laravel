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
      $descripcion = $rows[0][4];  
      \App\Http\Models\PlanillaFormativa::where(['mes'=>$this->mes, 'descripcion'=>$descripcion])->delete();              

        foreach ($rows as $row)
        {          
            
            if (substr($row[1],-4) == 'PNMC' && $fuente == 0 ) {
                $fuente = 2; 
                $meta = substr($row[1],0,4);
                continue;
            }
            if (substr($row[1],-4) == 'RLOC' && $fuente == 0 ) {
                $fuente = 1;
                $meta = substr($row[1],0,4);
                continue;
            }
            if (is_numeric($row[0]) && (strlen($row[0])==5) )
            {
                PlanillaFormativa::create([                                                              
                    "id_personal" => $row[0] ?? 0,                    
                    "codigo_plaza" => $row[1] ?? 0,                    
                    "nombres" => $row[2] ?? "",                
                    "dni" =>$row[3] ?? "00000000",
                    "monto" => $row[4] ?? 0,
                    "media" => $row[5] ?? 0,
                    "reintegro" => $row[6] ?? 0,
                    "descuento" => $row[7] ?? 0,
                    "total_ingreso" => $row[8] ?? 0,                    
                    "sctr_pension" => $row[9] ?? 0,
                    "sctr_salud" => $row[10] ?? 0,                    
                    "total_aporte" => $row[11] ?? 0,                                        
                    "meta" => $meta,
                    "fuente" => $fuente,
                    "mes" => $this->mes,
                    "anio" => 2023,
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
