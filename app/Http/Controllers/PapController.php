<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Pea;
use App\Http\Models\Estado;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;

class PapController extends BaseController
{

    public function index($anio){
        // $data = DB::select('CALL presupuesto(?)', array('2018'));
        $data =collect(DB::select(DB::raw("CALL sp_pap_impresion(:anio)"),['anio'=>$anio]));
        $estado = Estado::get();
         return response()->json([            
             "data" =>$data,
             "estado" => $estado
         ]);         
   }

   public function pap_air(){
     $data = DB::select("SELECT * FROM v_pap_air");
    //$data =collect(DB::select(DB::raw("CALL sp_pap_impresion(:anio)"),['anio'=>$anio]));
  //  $estado = Estado::get();
     return response()->json([            
         "data" =>$data         
     ]);         
}

   public function export($mes) 
    {
        $data= Excel::download((new PresupuestoExport())->forMes($mes), 'presupuestoExport.xlsx');
        return $data;
        //return (new PresupuestoExport())->download('invoices.xlsx');
        //$contents = Excel::raw(new PresupuestoExport, 'users.xlsx');
       // return $contents;
        //return Excel::download(new PresupuestoExport(), 'users.xlsx');
    }
}