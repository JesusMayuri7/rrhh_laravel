<?php

namespace App\Imports;

use App\Http\Models\CertificacionPresu;
use App\Http\Models\VCertificados;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class CertificacionPresuImport implements ToCollection,WithHeadingRow
{
    public function collection(Collection $rows)
    {
        // Revisar siempre el tipo de archivo, acuerdate que pasa por una transaccion
        //DB::connection()->enableQueryLog();
        //print_r(DB::getQueryLog(),1),
        // Poner Filtros por si se equivoca de archivo

      $certificado = (string) $rows[0]["certificado"];  
      
      $secuencias = VCertificados::select('secuencias')->where(['dsc_certificado'=> $certificado])->first();
      $secuencias =  $secuencias['secuencias'];
      $listSecuencias =  explode(",",$secuencias);
      CertificacionPresu::where(['certificado'=> $certificado])->delete();   
        foreach ($rows as $row)
        {                      
            if(in_array($row['secuencia'],$listSecuencias) || empty($secuencias))             
            {
                CertificacionPresu::create([                                                              
                    "ano_eje" => $row["ano_eje"],
                    "sec_ejec" => $row["sec_ejec"],
                    "certificado" => $row["certificado"],
                    "secuencia" => $row["secuencia"],
                    "correlativo" => $row["correlativo"],
                    "rubro" => $row["rubro"],
                    "cod_doc" => $row["cod_doc"],
                    "num_doc" => $row["num_doc"],
                    "fecha_doc" => $row["fecha_doc"],
                    "ruc" => $row["ruc"],
                    "clasificador" =>   $row["clasificador"],
                    "sec_func" => $row["sec_func"],
                    "moneda" => $row["moneda"],
                    "tipo_cambio" => $row["tipo_cambio"], 
                    "monto" => $row["monto"],
                    "monto_nacional" => $row["monto_nacional"],
                    "fecha_autorizacion" => $row["fecha_autorizacion"],
                    "fecha_bd_oracle" => $row["fecha_bd_oracle"],
                    "estado" => $row["estado"],
                    "tipo_certificado" => $row["tipo_certificado"],
                    "tipo_registro" => $row["tipo_registro"],
                    "estado_registro" => $row["estado_registro"],
                    "estado_envio" => $row["estado_envio"]
                ]);                                       
            }
        }  // foreach
    } //funcion

    public function headingRow(): int
    {
        return 1;
    }


}
