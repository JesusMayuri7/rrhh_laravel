<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Publicacion;
use App\Http\Models\Convocatorias;
use App\Http\Models\ConvocatoriasDB;
use App\Http\Models\Unidad;
use App\Exports\CapRptExport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;

class ConvocatoriaController extends BaseController
{

   public function matriz_control(Request $request) {
    $data =DB::select(DB::raw("CALL sp_matriz_control(?)"),[$request->input('idpap')]);
    return response()->json([
        "status" => true,
        "data" =>$data
    ]);       
   }

   public function list_convocatoria () {
    $unidades =Unidad::get();
    $data =Convocatorias::get();
    return response()->json([
        "status" => true,
        "data" =>$data,
        "unidades" => $unidades
    ]);       
   }
   
    public function nueva_convocatoria(Request $request){           
        try {
        $result=DB::transaction(function () use ($request) {
            if ($request->input('id')) {   
                $data = ConvocatoriasDB::find($request->input('id'));            
            } else {
                $data = new ConvocatoriasDB;            
            }            
            $data->nro_convocatoria = $request->input('nro_convocatoria');
            $data->jurados = $request->input('jurado');
//            $data->expediente = $request->input('expediente');
            $data->anio = 2019;            
            //$data->detalle = $request->input('detalle');                                    
            $data->org_unidad_id = $request->input('unidad.id');            
            $data->save();
           return $data;
           });
           return response()->json([
               "status" => true,
               "data" =>$result,
               "message"=>"Registro con exito",
               "log"=>"transaccion correcta"
               ],201);   
           } catch(Exception $e) {
                   return response()->json([
                       "status" => true,
                       "data" =>$result,
                       "message"=>"error al agregar convocatoria",
                       "log"=>"erro transaccion"
                   ],500);
           }
       }

   public function cap_rpt_vigente() 
    {
        //header('charset', 'utf-8');
        $data= Excel::download(new CapRptExport(), 'Personal_Vigente_Cap.xlsx');
        return $data;
        //return (new PresupuestoExport())->download('invoices.xlsx');
        //$contents = Excel::raw(new PresupuestoExport, 'users.xlsx');
       // return $contents;
        //return Excel::download(new PresupuestoExport(), 'users.xlsx');
    }
    
}