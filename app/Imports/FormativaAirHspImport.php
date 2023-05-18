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
                 //   "codigo_tipo_persona" =>$row[8],
                    "codigo_tipo_registro" =>$row[8],
                    "tipo_registro" =>$row[9],
                    "codigo_sub_tipo_registro" =>$row[10],
                    "sub_tipo_registro" =>$row[11],
                    "codigo_plaza" =>$row[12],
                    "codigo_plazaue" =>$row[13],
                    "estado" =>$row[14],
                    "tipo_documento" =>$row[15],
                    "numero_documento" =>$row[16],
                    "apellido_paterno" =>$row[17],
                    "apellido_materno" =>$row[18],
                    "nombres" =>$row[19],
                    "sexo" =>$row[20],
                    "desc_sexo" =>$row[21],
                    "fecha_nacimiento" =>$row[22],
                    "ingreso" =>$row[23],
                    "desc_ingreso" =>$row[24],
                    "fecha_ingreso" =>$row[25],
                    "regimen_laboral" =>$row[26],
                    "desc_regimen_laboral" =>$row[27],
                    "condicion" =>$row[28],
                    "desc_condicion" =>$row[29],
                    "grupo_ocupacional" =>$row[30],
                    "desc_grupo_ocupacional" =>$row[31],
                    "cargo_estructural" =>$row[34],
                    "desc_cargo_estructural" =>$row[36],
                    //"horas" =>$row[0],
                    "cargo_funcional" =>$row[37],
                    "desc_cargo_funcional" =>$row[38],
                    "banco" =>$row[41],
                    "desc_banco" =>$row[42],
                    "tipo_cuenta" =>$row[43],
                    "desc_tipo_cuenta" =>$row[44],
                    "numero_cuenta" =>$row[45],
                    "cci" =>$row[46],
                    //"fecha_afp" =>$row[47],
                    //"afp" =>$row[48],
                    //"desc_afp" =>$row[49],
                    //"carnet_afp" =>$row[50],
                    //"autogenerado" =>$row[51],
                    "fecha_alta" =>$row[54],
                    "fecha_estado" =>$row[55],
                    "fecha_inicio_vigencia_reg" =>$row[58],
                    "fecha_fin_vigencia_reg" =>$row[59],
                    //"secuencia_funcional" =>$row[0],
                    //"codigo_categoria_presupuestal" =>$row[57],
                    //"desc_categoria_presupuestal" =>$row[58],
                    "fecha_inicio_vigencia_reg" =>$row[58],
                    "fecha_fin_vigencia_reg" =>$row[59],
                    "honorarios" =>$row[69],
                    "fuente" => $row[70],  
                    "media_subvencion_primera" => strlen($row[75])==0 ? 0: $row[75],
                    "media_subvencion_segunda" => strlen($row[78])==0 ? 0: $row[78], 
                    
                ]); 
        }           
         }  // for
    } //funcion




}
