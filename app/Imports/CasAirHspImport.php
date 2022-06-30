<?php

namespace App\Imports;

use App\Http\Models\AirHspCasDB;
use Carbon\Carbon;
use App\Http\Models\CodigosPvn;
use App\Http\Models\AirHspCodigosDB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class CasAirHspImport implements ToCollection,WithHeadingRow
{
    public function limitColumns(): int
    {
        return 80;
    }
    /**
    * @param array $row    
    */

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
           AirHspCasDB::create([                               
                "codigo_ue" =>$row["codigo_ue"],
                "tipo_establecimiento" =>$row["tipo_establecimiento"],
                "desc_tipo_establecimiento" =>$row["desc_tipo_establecimiento"],
                "establecimiento" =>$row["establecimiento"],
                "desc_establecimiento" =>$row["desc_establecimiento"],
                "codigo_establecimiento_ue" =>$row["codigo_establecimiento_ue"],
                "unidad_organica" =>$row["unidad_organica"],
                "desc_unidad_organica" =>$row["desc_unidad_organica"],
                "codigo_tipo_registro" =>$row["codigo_tipo_registro"],
                "codigo_sub_tipo_registro" =>$row["codigo_sub_tipo_registro"],
                "codigo_plaza" =>$row["codigo_plaza"],
                "codigo_plazaue" =>$row["codigo_plazaue"],
                "estado" =>$row["estado"],
                "tipo_documento" =>$row["tipo_documento"],
                "numero_documento" =>$row["numero_documento"],
                "apellido_paterno" =>$row["apellido_paterno"],
                "apellido_materno" =>$row["apellido_materno"],
                "nombres" =>$row["nombres"],
                "sexo" =>$row["sexo"],
                "desc_sexo" =>$row["desc_sexo"],
                "fecha_nacimiento" => strlen($row["fecha_nacimiento"])==0 ? null:Carbon::createFromFormat('d/m/Y',$row["fecha_nacimiento"]),
                "ingreso" =>$row["ingreso"],
                "desc_ingreso" =>$row["desc_ingreso"],
                "fecha_ingreso" => strlen($row["fecha_ingreso"])==0 ? null:Carbon::createFromFormat('d/m/Y',$row["fecha_ingreso"]),
                "regimen_laboral" =>$row["regimen_laboral"],
                "desc_regimen_laboral" =>$row["desc_regimen_laboral"],
                "condicion" =>$row["condicion"],
                "desc_condicion" =>$row["desc_condicion"],
                "grupo_ocupacional" =>$row["grupo_ocupacional"],
                "desc_grupo_ocupacional" =>$row["desc_grupo_ocupacional"],
                "cargo_estructural" =>$row["cargo_estructural"],
                "desc_cargo_estructural" =>$row["desc_cargo_estructural"],
                "horas" =>$row["horas"],
                "cargo_funcional" =>$row["cargo_funcional"],
                "desc_cargo_funcional" =>$row["desc_cargo_funcional"],
                "banco" =>$row["banco"],
                "desc_banco" =>$row["desc_banco"],
                "tipo_cuenta" =>$row["tipo_cuenta"],
                "desc_tipo_cuenta" =>$row["desc_tipo_cuenta"],
                "numero_cuenta" =>$row["numero_cuenta"],
                "cci" =>$row["cci"],
                "fecha_afp" =>$row["fecha_afp"],
                "afp" =>$row["afp"],
                "desc_afp" =>$row["desc_afp"],
                "carnet_afp" =>$row["carnet_afp"],
                "autogenerado" =>$row["autogenerado"],
                "fecha_alta" => strlen($row["fecha_alta"])==0 ? null:Carbon::createFromFormat('d/m/Y',$row["fecha_alta"]),
                "fecha_estado" => strlen($row["fecha_estado"])==0 ? null: Carbon::createFromFormat('d/m/Y',$row["fecha_estado"]),
                "fecha_inicio_vigencia_cas" =>strlen($row["fecha_inicio_vigencia_cas"])==0 ? null: Carbon::createFromFormat('d/m/Y',$row["fecha_inicio_vigencia_cas"]),
                "fecha_fin_vigencia_cas" =>$row["fecha_fin_vigencia_cas"],
                "secuencia_funcional" =>$row["secuencia_funcional"]?? '',
                "codigo_categoria_presupuestal" =>$row["codigo_categoria_presupuestal"],
                "desc_categoria_presupuestal" =>$row["desc_categoria_presupuestal"],
                "codigo_producto" =>$row["codigo_producto"]?? '',
                "desc_producto" =>$row["desc_producto"]?? ' ',
                "codigo_actividad" =>$row["codigo_actividad"]?? '',
                "desc_actividad" =>$row["desc_actividad"]?? '',
                "codigo_funcion" =>$row["codigo_funcion"]?? '',
                "desc_funcion" =>$row["desc_funcion"]?? '',
                "codigo_division_funcional" =>$row["codigo_division_funcional"]?? '',
                "desc_division_funcional" =>$row["desc_division_funcional"]?? '',
                "codigo_grupo_funcional" =>$row["codigo_grupo_funcional"]?? '',
                "desc_grupo_funcional" =>$row["desc_grupo_funcional"]?? '',
                "codigo_finalidad" =>$row["codigo_finalidad"]?? '',
                "desc_finalidad" =>$row["desc_finalidad"]?? '',
                "codigo_departamento" =>$row["codigo_departamento"]?? '',
                "desc_departamento" =>$row["desc_departamento"]?? '',
                "codigo_provincia" =>$row["codigo_provincia"]?? '',
                "desc_provincia" =>$row["desc_provincia"]?? '',
                "codigo_distrito" =>$row["codigo_distrito"]?? '',
                "desc_distrito" =>$row["desc_distrito"]?? '',
                "codigo_intervencion_estrategica" =>$row["codigo_intervencion_estrategica"],
                "desc_intervencion_estrategica" =>$row["desc_intervencion_estrategica"],    
                "desc_motivo_creacion_registro" =>$row["desc_motivo_creacion_registro"],    
                "honorarios" =>$row["honorarios"],                  
                "fuente" =>$row["fuente"],   
                "essalud" =>$row["essalud"],   
            ]);            
         }  // for
    } //funcion

    public function headingRow(): int
    {
        return 4;
    }


}
