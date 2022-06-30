<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Meta;
use App\Http\Models\PlanillaCas;
use App\Imports\PlanillaCasImport;
//use Maatwebsite\Excel\Facades\Excel;
use Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class PlanillaCasController extends BaseController
{
  
   public function import(Request $request) 
   {
       $data = [];
       $destinationPath = 'uploads';
       $file = $request->file('file');  
       $mes = $request->input("mes");    
       $file->move(storage_path('app'),$file->getClientOriginalName());
       if (Storage::disk('local')->exists($file->getClientOriginalName())) 
       {        
          $data = Excel::import(new PlanillaCasImport($request->input("mes")), $file->getClientOriginalName(), 'local', \Maatwebsite\Excel\Excel::XLSX);
          //Excel::import(new AirHspImport, 'ReporteDatoslaboralesNomina1078.xlsx', 'local', \Maatwebsite\Excel\Excel::XLSX);           
           return response()->json([
               "status" => true,
               "data" => $data
           ]); 
       } 
   }

   public function planilla_cas_anual(Request $request){
    // $data = DB::select('CALL presupuesto(?)', array('2018'));
    $data=[];
    if ($request->input("planilla")===0) {
        $data =DB::select(DB::raw("CALL sp_planilla_cas_bruto(0)"));  // revisar mes ? estaba con 6    
    }
    if ($request->input("planilla")===2) {
        $data =DB::select(DB::raw("CALL sp_planilla_cas_neto(?)"),array($request->input("mes")));  // revisar mes ? estaba con 6    
    }
    if ($request->input("planilla")===1) {
    $data =DB::select(DB::raw("CALL sp_planilla_cas_bruto(?)"),array($request->input("mes")));  // revisar mes ? estaba con 6    
    }


     return response()->json([       
         'status'  => 1,
         "data" =>$data,
     ]);        
   }

   public function planilla_cas($anio){    
    $data=[];
    $data =DB::select(DB::raw('SELECT * from v_planilla_cas WHERE anio  = ?'),[$anio]);  
     return response()->json([       
         'status'  => 1,
         "data" =>$data,
     ]);        
   }

    public function proyeccion_cas(Request $request) {
      // dd($request->input('mes'));                
        $data =DB::select(DB::raw("CALL sp_programacion_cas(?,?,?,?)"),array($request->input('mes'),$request->input('vigencia'),$request->input('base'),$request->input("uit")));  
         return response()->json([       
             'status'  => 1,
             "data" =>$data,
         ]);        
    }

    public function proyeccion_dos_cas(Request $request) {
        // dd($request->input('mes'));                
          $data =DB::select(DB::raw("CALL sp_programacion_cas2(?,?,?,?)"),array($request->input('mes'),$request->input('vigencia'),$request->input('estado'),$request->input('uit')));  
           return response()->json([       
               'status'  => 1,
               "data" =>$data,
           ]);        
      }
    
      public function proyeccion_tres_cas(Request $request) {
        // dd($request->input('mes'));                
          $data =DB::select(DB::raw("CALL sp_programacion_cas3(?,?,?,?,?)"),array($request->input('mes'),$request->input('vigencia'),$request->input('estado'),$request->input('uit'),$request->input('base')));  
           return response()->json([       
               'status'  => 1,
               "data" =>$data,
           ]);        
      }
}