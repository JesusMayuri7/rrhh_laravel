<?php

namespace App\Imports;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use App\Http\Models\PersonalCap;

class PersonalCapImport implements ToCollection,WithHeadingRow
{
    public function collection(Collection $rows)
    {
      //$descripcion = $rows[0][4];  
      // return $rows;
        foreach ($rows as $row)
        {                                
                PersonalCap::create([                                                                                               
                    "id_personal" => $row["id_personal"],
                    "nombres" => $row["nombres"],                
                    "nu_dociden" => $row["nu_dociden"],
                    "nu_ruc" => $row["nu_ruc"],
                    "id_contrato" => $row["id_contrato"] ?? 0,
                    "fe_contrato" => $row["fe_contrato"],
                    "nu_contrato" => $row["nu_contrato"],                                        
                    "fe_inicont" => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row["fe_inicont"])),
                    "fe_fincont" => Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row["fe_fincont"])),
                    "mt_contmn" => $row["mt_contmn"]?? 0,
                    "id_servicio" => $row["id_servicio"],
                    "ds_servicio" => $row["ds_servicio"],
                    "id_mnemonico" => $row["id_mnemonico"],
                    "id_cargo" => $row["id_cargo"],
                    "ds_cargo" => $row["ds_cargo"],
                    "id_jerarquia" => $row["id_jerarquia"],
                    "ds_jerarquia" => $row["ds_jerarquia"],
                    "id_prestamo" => $row["id_prestamo"],
                    "id_plaza" => $row["id_plaza"],
                    "mt_plaza" => $row["mt_plaza"] ?? 0,
                    "id_nivel" => $row["id_nivel"],
                    "fe_ingreso" =>Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row["fe_ingreso"])),
                    "fe_cese" =>Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row["fe_cese"]))
                ]);                                       
        }  // foreach
    } //funcion

    public function headingRow(): int
    {
        return 1;
    }


}
