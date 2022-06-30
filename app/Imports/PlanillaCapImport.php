<?php

namespace App\Imports;

use App\Http\Models\PlanillaCap;
use App\Http\Models\PlanillaCapCodigos;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;


class PlanillaCapImport implements ToCollection,WithHeadingRow
{
  
    private $campos;
    private $mes;
    public function __construct(array $campos,string $mes)
    {
        $this->campos = $campos;
        $this->mes = $mes;
    }

    public function collection(Collection $rows)
    {
        $descripcion = $rows[0]['t_encabe'];          
        $anio = substr($rows[0]['cod_periodo'], 0,4);
        //$mes =  substr($rows[0]['cod_periodo'], 4, 6);
        $item = array_values($this->campos[0][0]);  
        $dataSet = [];   

      \App\Http\Models\PlanillaCap::where(['mes'=>$this->mes, 'descripcion'=>$descripcion])->delete();              

        foreach ($rows as $row)
        {                        
                $persona= PlanillaCap::create([                                                              
                    "cod_trabajador" => $row['cod_trabajador'],                
                    "cod_periodo" =>$row['cod_periodo'],
                    "txt_nombres"=>$row['txt_nombres'],      
                    "cod_plaza"=>$row['cod_plaza'],
                    "txt_cargo"=>$row['txt_cargo'],            
                    "cod_zonal"=>$row['cod_zonal'],
                    "cod_tipzon"=>$row['cod_tipzon'],
                    "cod_zonund"=>$row['cod_zonund'],
                    "cod_jerarquia"=>$row['cod_jerarquia'],
                    "cod_aredir"=>$row['cod_aredir'],
                    "cod_areger"=>$row['cod_areger'],
                    "flg_sist_pens"=>$row['flg_sist_pens'],
                    "txt_sist_pens"=>$row['txt_sist_pens'],
                  "num_dias_base"=>$row['num_dias_base'],
                  "fec_ini_vacsub"=>$row['fec_ini_vacsub'],
                  "fec_fin_vacsub"=>$row['fec_fin_vacsub'],
                  "cod_mnemonico"=>$row['cod_mnemonico'],
                  "tot_aportes"=>$row['tot_aportes'],
                  "tot_descuentos"=>$row['tot_descuentos'],
                  "tot_ingresos"=>$row['tot_ingresos'],    
                  "fuente"=>null,                  
                  "mes" => $this->mes,
                  "anio" => $anio,
                  "descripcion" => $descripcion
                ]);                                                               
          
                for($i=31; $i<91; $i++) 
                {              
                   if (is_numeric(($row[$item[$i]]))) {
                        if ($row[$item[$i]] > 0 ) {                   
                                $objeto=[];
                            // $aja= array_add($aja, 'codigo',$item[$i]);   
                            //if($item[$i] == ("c_01".str_pad($j,2,"0",STR_PAD_LEFT)) )        
                                $objeto= array_add($objeto,'planilla_id', $persona->id);                                
                                $objeto= array_add($objeto,'id_personal', $row['cod_trabajador']);                                
                                $objeto= array_add($objeto, 'codigo',$item[$i]);      
                                $objeto= array_add($objeto,'id_codigo', $i);                                                                                                       
                                $objeto= array_add($objeto,'monto', $row[$item[$i]]);                                                                                                       
                                array_push($dataSet,$objeto);             
                        }
                   }
               }                                
                    //array_push($persona,$objeto);             
        }  // foreach
            $insert_data = collect($dataSet);
            foreach ($insert_data->chunk(500) as $chunk)
                {
                    PlanillaCapCodigos::insert($chunk->toArray());                
                }
                   
        if (($this->mes > 0) && ($this->mes < 13) ) {
            $data =DB::select(DB::raw("CALL sp_actualizar_fuente_planilla_cap(?,?)"),[$this->mes,$descripcion]);  // revisar mes ? estaba con 6    
        }


    } //funcion

    public function headingRow(): int
    {
        return 1;
    }


}
