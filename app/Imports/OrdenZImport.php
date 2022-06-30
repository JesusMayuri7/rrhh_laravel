<?php

namespace App\Imports;

use App\Http\Models\OrdenZDB;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class OrdenZImport implements ToCollection,WithHeadingRow,WithBatchInserts,WithChunkReading
{

    public function collection(Collection $rows)
    {
        foreach ($rows as $row) 
        {
            $data= $row->toArray();           
            $item = array_values($data);            
            $date = str_replace('/', '-', $item[14]);
            $fecha = date("Y-m-d", strtotime($date));
            $date = str_replace('/', '-', $item[15] );
            $fecha_inicio = date("Y-m-d", strtotime($date));
            $date = str_replace('/', '-', $item[16] );
            $fecha_fin = date("Y-m-d", strtotime($date));
            
             OrdenZDB::insert([
            'nro_pedido'     => $item[0],
            'nro_orden'     => $item[1],
            'nemonico'    => $item[2],
            'meta'    => $item[3],
            'ejecutora_id' => $item[4],
            'ejecutora_sede' => $item[5],
            'tipo' => 'SERVICIO',
            'denominacion' => $item[7],
            'plazo_dias' => $item[9],
            'responsable' => $item[10],
            'ruc' => $item[11],
            'proveedor' => $item[12],
            'monto' => $item[13],           
            'fecha' => $fecha,            
            'fecha_inicio' => $fecha_inicio,            
            'fecha_fin' => $fecha_fin
            ]);
        }
    }

    public function batchSize(): int
    {
        return 250;
    }
    
    public function chunkSize(): int
    {
        return 1000;
    }

    public function headingRow(): int
    {
        return 11;
    }
}
