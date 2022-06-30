<?php

namespace App\Imports;

use App\Http\Models\PresupuestoDB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class PresupuestoImport implements ToCollection,WithHeadingRow,WithBatchInserts
{
   
    public function collection(Collection $rows)
    {
        $anio = (string) $rows[0]["ano_eje"];  
        //CertificacionPresu::where(['certificado'=> $certificado])->delete();   
        PresupuestoDB::where(['ano_eje'=>$anio])->delete();
        
        foreach ($rows as $row)
        {  

            PresupuestoDB::insert([     
            'ano_eje'     => $row['ano_eje'],
            'nivel_gob'    => $row['nivel_gob'],
            'sector' => $row['sector'],
            'pliego' => $row['pliego'],
            'u_ejecutora' => $row['u_ejecutora'],
            'sec_ejec' => $row['sec_ejec'],
            'programa_pptal' => $row['programa_pptal'],
            'tipo_prod_proy' => $row['tipo_prod_proy'],
            'producto_proyecto' => $row['producto_proyecto'],
            'tipo_act_obra_ac' => $row['tipo_act_obra_ac'],
            'activ_obra_accinv' => $row['activ_obra_accinv'],
            'funcion' => $row['funcion'],
            'division_fn' => $row['division_fn'],
            'grupo_fn' => $row['grupo_fn'],
            'meta' => $row['meta'],
            'finalidad' => $row['finalidad'],
            'unidad_medida' => $row['unidad_medida'],
            'cant_meta_anual' => $row['cant_meta_anual'],
            'cant_meta_sem'    => $row['cant_meta_sem'],
            'avan_fisico_anual' => $row['avan_fisico_anual'],
            'avan_fisico_sem' => $row['avan_fisico_sem'],
            'sec_func' => $row['sec_func'],
            'departamento_meta' => $row['departamento_meta'],
            'provincia_meta' => $row['provincia_meta'],
            'distrito_meta' => $row['distrito_meta'],
            'fuente_financ' => $row['fuente_financ'],
            'rubro' => $row['rubro'],
            'categoria_gasto' => $row['categoria_gasto'],
            'tipo_transaccion' => $row['tipo_transaccion'],
            'generica' => $row['generica'],
            'subgenerica' => $row['subgenerica'],
            'subgenerica_det' => $row['subgenerica_det'],
            'especifica' => $row['especifica'],
            'especifica_det' => $row['especifica_det'],
            'tipo_recurso'     => $row['tipo_recurso'],
            'mto_pia'    => $row['mto_pia'],
            'mto_modificaciones' => $row['mto_modificaciones'],
            'mto_pim' => $row['mto_pim'],
            'mto_certificado' => $row['mto_certificado'],
            'mto_compro_anual' => $row['mto_compro_anual'],
            'mto_at_comp_01' => $row['mto_at_comp_01'],
            'mto_at_comp_02' => $row['mto_at_comp_02'],
            'mto_at_comp_03' => $row['mto_at_comp_03'],
            'mto_at_comp_04' => $row['mto_at_comp_04'],
            'mto_at_comp_05' => $row['mto_at_comp_05'],
            'mto_at_comp_06' => $row['mto_at_comp_06'],
            'mto_at_comp_07' => $row['mto_at_comp_07'],
            'mto_at_comp_08' => $row['mto_at_comp_08'],
            'mto_at_comp_09' => $row['mto_at_comp_09'],
            'mto_at_comp_10' => $row['mto_at_comp_10'],
            'mto_at_comp_11' => $row['mto_at_comp_11'],
            'mto_at_comp_12' => $row['mto_at_comp_12'],
            'mto_devenga_01' => $row['mto_devenga_01'],
            'mto_devenga_02' => $row['mto_devenga_02'],
            'mto_devenga_03' => $row['mto_devenga_03'],
            'mto_devenga_04' => $row['mto_devenga_04'],
            'mto_devenga_05' => $row['mto_devenga_05'],
            'mto_devenga_06' => $row['mto_devenga_06'],
            'mto_devenga_07' => $row['mto_devenga_07'],
            'mto_devenga_08' => $row['mto_devenga_08'],
            'mto_devenga_09' => $row['mto_devenga_09'],
            'mto_devenga_10' => $row['mto_devenga_10'],
            'mto_devenga_11' => $row['mto_devenga_11'],
            'mto_devenga_12' => $row['mto_devenga_12'],
            'mto_girado_01' => $row['mto_girado_01'],
            'mto_girado_02' => $row['mto_girado_02'],
            'mto_girado_03' => $row['mto_girado_03'],
            'mto_girado_04' => $row['mto_girado_04'],
            'mto_girado_05' => $row['mto_girado_05'],
            'mto_girado_06' => $row['mto_girado_06'],
            'mto_girado_07' => $row['mto_girado_07'],
            'mto_girado_08' => $row['mto_girado_08'],
            'mto_girado_09' => $row['mto_girado_09'],
            'mto_girado_10' => $row['mto_girado_10'],
            'mto_girado_11' => $row['mto_girado_11'],
            'mto_girado_12' => $row['mto_girado_12'],
            'mto_pagado_01' => $row['mto_pagado_01'],
            'mto_pagado_02' => $row['mto_pagado_02'],
            'mto_pagado_03' => $row['mto_pagado_03'],
            'mto_pagado_04' => $row['mto_pagado_04'],
            'mto_pagado_05' => $row['mto_pagado_05'],
            'mto_pagado_06' => $row['mto_pagado_06'],
            'mto_pagado_07' => $row['mto_pagado_07'],
            'mto_pagado_08' => $row['mto_pagado_08'],
            'mto_pagado_09' => $row['mto_pagado_09'],
            'mto_pagado_10' => $row['mto_pagado_10'],
            'mto_pagado_11' => $row['mto_pagado_11'],
            'mto_pagado_12' => $row['mto_pagado_12'],

            ]);
        }
    }

    public function batchSize(): int
    {
        return 500;
    }
    


    public function headingRow(): int
    {
        return 1;
    }
}
