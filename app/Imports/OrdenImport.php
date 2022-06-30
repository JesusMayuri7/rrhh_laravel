<?php

namespace App\Imports;

use App\Http\Models\OrdenDB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class OrdenImport implements ToModel,WithHeadingRow,WithBatchInserts,WithChunkReading
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new OrdenDB([
            'caso'     => $row['caso'],
            'centro_costo' => $row['centro_costo'],
            'nombre_depend' => $row['nombre_depend'],
            'nro_orden' => $row['nro_orden'],
            'fecha_orden' => $row['fecha_orden'],
            'opcion' => $row['opcion'],
            'nro_pedido' => $row['nro_pedido'],
            'nro_requer' => $row['nro_requer'],
            'tipo_pedido' => $row['tipo_pedido'],
            'exp_siaf' => $row['exp_siaf'],
            'nro_ruc' => $row['nro_ruc'],
            'nombre_prov' => $row['nombre_prov'],
            'valor' => $row['valor'],
            'wtipo_proceso' => $row['wtipo_proceso'],
            'dsc_orden' => $row['dsc_orden'],
            'tipo_bien' => $row['tipo_bien'],
            'sec_cuadro' => $row['sec_cuadro'],
        ]);
    }

    public function batchSize(): int
    {
        return 250;
    }
    
    public function chunkSize(): int
    {
        return 1000;
    }
}
