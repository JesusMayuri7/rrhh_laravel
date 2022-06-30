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


class PlanillaCapCtsImport implements ToCollection,WithHeadingRow
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
        $descripcion ='CTS';          
        $anio = '2021';
        //$mes =  substr($rows[0]['cod_periodo'], 4, 6);
        $item = array_values($this->campos[0][0]);  
        $dataSet = [];   

        \App\Http\Models\PlanillaCap::where(['mes'=>$this->mes, 'descripcion'=>$descripcion])->delete();              

        foreach ($rows as $row)
        {                        
                $persona= PlanillaCap::create([                                                              
                    "cod_trabajador" => $row['cod_trabaj'],                
                    //"cod_periodo" =>$anio,
                    "txt_nombres"=>$row['txt_apenom'],      
                    //"cod_plaza"=>$row['cod_plaza'],
                    "txt_cargo"=>$row['txt_cargos'],            
                    //"cod_zonal"=>$row['cod_zonal'],
                    //"cod_tipzon"=>$row['cod_tipzon'],
                    //"cod_zonund"=>$row['cod_zonund'],
                    //"cod_jerarquia"=>$row['cod_jerarquia'],
                    //"cod_aredir"=>$row['cod_aredir'],
                    //"cod_areger"=>$row['cod_areger'],
                    //"flg_sist_pens"=>$row['flg_sist_pens'],
                    //"txt_sist_pens"=>$row['txt_sist_pens'],
                  //"num_dias_base"=>$row['num_dias_base'],
                  //"fec_ini_vacsub"=>$row['fec_ini_vacsub'],
                  //"fec_fin_vacsub"=>$row['fec_fin_vacsub'],
                  "cod_mnemonico"=>trim(substr($row['txt_mnemon'],0,4)),
                  //"tot_aportes"=>$row['tot_aportes'],
                  //"tot_descuentos"=>$row['tot_descuentos'],
                  //"tot_ingresos"=>$row['tot_ingresos'],    
                  "fuente"=> $row['cod_prestamo'],                  
                  "mes" => $this->mes,
                  "anio" => $anio,
                  "descripcion" => $descripcion
                ]);                                                               
          
              //  for($i=12; $i<13; $i++) 
                {              
                    $i=12;
                   if (is_numeric(($row['imp_montot']))) {
                        if ($row['imp_montot'] > 0 ) {                   
                                $objeto=[];                            
                                $objeto= array_add($objeto,'planilla_id', $persona->id);                                
                                $objeto= array_add($objeto,'id_personal', $row['cod_trabaj']);                                
                                $objeto= array_add($objeto, 'codigo','C_0305');      
                                $objeto= array_add($objeto,'id_codigo', 29);                                                                                                       
                                $objeto= array_add($objeto,'monto', $row['imp_montot']);                                                                                                       
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
       
    } //funcion

    public function headingRow(): int
    {
        return 1;
    }


}
