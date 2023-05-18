<?php

namespace App\Imports;

use App\Http\Models\Devengado;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class DevengadoImport implements ToCollection,WithHeadingRow
{
    public function collection(Collection $rows)
    {
        // Revisar siempre el tipo de archivo, acuerdate que pasa por una transaccion
        //DB::connection()->enableQueryLog();
        //print_r(DB::getQueryLog(),1),
        // Poner Filtros por si se equivoca de archivo

      $ultimo_item =  $rows->last();
      $certificado = $ultimo_item["certificado"];
      //$certificado = (string) $rows[0]["certificado"];  

      Devengado::where(['certificado'=> $certificado])->delete();   
        foreach ($rows as $row)
        {                                   
                Devengado::create([                                                              
                    "ano_eje" => $row["ano_eje"],      
                    "certificado" => $row["certificado"],      
                    "fuente_financ" => $row["fuente_financ"],      
                    "clasificador"=> $row["clasificador"],   
                    "sec_func" => $row["sec_func"],   
                    "mes_proceso"=> $row["mes_proceso"],   
                    "fase" => $row["fase"],   
                    "estado" => $row["estado"],
                    "estado_envio" => $row["estado_envio"],
                    "num_doc"  => $row["num_doc"],   
                    "fecha_doc"=> $row["fecha_doc"],
                    "ruc" => $row["ruc"],
                    "clasificador"=> $row["clasificador"]  ,     
                    "moneda"=> $row["moneda"],
                    "tipo_cambio"=> $row["tipo_cambio"],
                    "monto"=> $row["monto"],
                    "secuencia"=> $row["secuencia"],
                    "secuencia_padre"=> $row["secuencia_padre"],
                    "monto_nacional"=> $row["monto_nacional"],
                    "fecha_autorizacion"=> $row["fecha_autorizacion"],
                    "fecha_bd_oracle"  => $row["fecha_bd_oracle"]
                ]);                                       
        }  // foreach
    } //funcion

    public function headingRow(): int
    {
        return 1;
    }


}
