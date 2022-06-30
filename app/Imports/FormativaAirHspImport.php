<?php

namespace App\Imports;

use App\Http\Models\AirHspFormativaDB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;

//HeadingRowFormatter::default('none');

class FormativaAirHspImport implements ToCollection
{

     public function collection(Collection $rows)
    {
        //$data = array_values($rows->toArray());
        //foreach ($rows as $row_index=>$row) 
        foreach ($rows as $row) 
        {
            if(strlen(trim($row[0]))==6 && trim($row[0])=='001078')
            {
                AirHspFormativaDB::create([                                           
                    "codigo_ue" =>$row[0] ?? 7,
                    "tipo_establecimiento" =>$row[1],
                    "desc_tipo_establecimiento" =>$row[2],
                    "establecimiento" =>$row[3],
                    "desc_establecimiento" =>$row[4],
                    "codigo_establecimiento_ue" =>$row[5],
                    "unidad_organica" =>$row[6],
                    "desc_unidad_organica" =>$row[7],
                    "codigo_tipo_persona" =>$row[8],
                    "codigo_tipo_registro" =>$row[9],
                    "codigo_plaza" =>$row[10],
                    "codigo_plazaue" =>$row[11],
                    "estado" =>$row[12],
                    "tipo_documento" =>$row[13],
                    "numero_documento" =>$row[14],
                    "apellido_paterno" =>$row[15],
                    "apellido_materno" =>$row[16],
                    "nombres" =>$row[17],
                    "sexo" =>$row[18],
                    "desc_sexo" =>$row[19],
                    "fecha_nacimiento" =>$row[20],
                    "ingreso" =>$row[21],
                    "desc_ingreso" =>$row[22],
                    "fecha_ingreso" =>$row[23],
                    "regimen_laboral" =>$row[24],
                    "desc_regimen_laboral" =>$row[25],
                    "condicion" =>$row[26],
                    "desc_condicion" =>$row[27],
                    "grupo_ocupacional" =>$row[28],
                    "desc_grupo_ocupacional" =>$row[29],
                    "cargo_estructural" =>$row[32],
                    "desc_cargo_estructural" =>$row[33],
                    //"horas" =>$row[0],
                    "cargo_funcional" =>$row[35],
                    "desc_cargo_funcional" =>$row[36],
                    "banco" =>$row[39],
                    "desc_banco" =>$row[40],
                    "tipo_cuenta" =>$row[41],
                    "desc_tipo_cuenta" =>$row[42],
                    "numero_cuenta" =>$row[43],
                    "cci" =>$row[44],
                    "fecha_afp" =>$row[45],
                    "afp" =>$row[46],
                    "desc_afp" =>$row[47],
                    "carnet_afp" =>$row[48],
                    "autogenerado" =>$row[49],
                    "fecha_alta" =>$row[50],
                    "fecha_estado" =>$row[51],
                    "fecha_inicio_vigencia_cas" =>$row[53],
                    "fecha_fin_vigencia_cas" =>$row[54],
                    //"secuencia_funcional" =>$row[0],
                    "codigo_categoria_presupuestal" =>$row[55],
                    "desc_categoria_presupuestal" =>$row[56],

                    "honorarios" =>$row[65],
                    "fuente" => $row[66],  
                    "media_subvencion_primera" => strlen($row[71])==0 ? 0: $row[71],
                    "media_subvencion_segunda" => strlen($row[74])==0 ? 0: $row[74], 
                    
                ]); 
        }           
         }  // for
    } //funcion




}
