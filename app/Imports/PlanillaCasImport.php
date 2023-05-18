<?php

namespace App\Imports;

use App\Http\Models\PlanillaCas;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class PlanillaCasImport implements ToCollection
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
      $fuente = '';
      \App\Http\Models\PlanillaCas::where(['mes'=>$this->mes, 'descripcion'=>$descripcion])->delete();              

        foreach ($rows as $row)
        {        
            //if (strlen($row[0]) == 4 ) {                
            if (strpos($row[1],'RLOC') !== false )
            {
                $meta = substr($row[1], 0,4);
                $fuente = 'RLOC';
                continue;
            }
            if (strpos($row[1],'PNMC') !== false) {                
                $meta = substr($row[1], 0,4);
                $fuente = 'PNMC';
                continue;
            }                        

            if (is_numeric($row[0]) && (strlen($row[0])==5) && (strlen($fuente)==4))
            {
                PlanillaCas::create([                                                              
                    "id_personal" => $row[0] ?? 0,                    
                    
                    "nombres" => $row[1] ?? "",                
                    "monto" => $row[6] ?? 0,
                    //"incremento"=>$row[2] ?? 0,
                    //"aguinaldo" => $row[3] ?? 0,
                    //"bono" => $row[3] ?? 0,
                    "reintegro" => $row[5] ?? 0,
                    "total_ingreso" => $row[6] ?? 0,
                    "retencion_cuarta" => $row[7] ?? 0,  
                    "dscto_no_remunerativo_01" => $row[9] ?? 0,
                    "dscto_no_remunerativo_02" => $row[10] ?? 0,
                    "otros_no_afecto" => $row[11] ?? 0,                                        
                    "otros_si_afecto" => $row[12] ?? 0,                                        
                    "afp_base" => $row[16] ?? 0,    
                    "afp_comision" => $row[18] ?? 0,    
                    "afp_prima" => $row[19] ?? 0,    
                    "essalud" => $row[24] ?? 0,
                    "sctr_pension" => $row[22] ?? 0,
                    "sctr_salud" => $row[23] ?? 0,
                    "total_aporte" => $row[25] ?? 0,
                    "total_descuento" => 0,
                    "total_neto" => $row[26] ?? 0,
                    "meta" => $meta,
                    "fuente" => $fuente,
                    "mes" => $this->mes,
                    "anio" => 2023,
                    "descripcion" => $descripcion,
                    "dni" =>$row[28] ?? "00000000",
                    //"dni" =>$row[27] ?? "00000000",
                ]);
            }
           /* else
            {
                break;
            }
             */          
        }  // foreach

        if (($this->mes) > 0 && ($this->mes < 13) ) {
        //    $data =DB::select(DB::raw("CALL sp_actualizar_fuente_planilla_cas(?)"),[$this->mes]);  // revisar mes ? estaba con 6    
        }
    } //funcion




}
