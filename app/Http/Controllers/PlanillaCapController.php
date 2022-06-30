<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Imports\PlanillaCapImport;
use App\Imports\PlanillaCapCtsImport;
//use Maatwebsite\Excel\Facades\Excel;
use Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\HeadingRowImport;

class PlanillaCapController extends BaseController
{
   public function index($anio) {
    $data=[];
    $data =DB::select(DB::raw('SELECT * from v_planilla_cap WHERE anio = ?'),[$anio]);  
     return response()->json([       
         'status'  => 1,
         "data" =>$data,
     ]); 
   }

  
   public function import(Request $request) 
   {
       $data = [];
       $destinationPath = 'uploads';
       $file = $request->file('file');  
       $mes =  $request->input("mes");    
       $file->move(storage_path('app'),$file->getClientOriginalName());
       if (Storage::disk('local')->exists($file->getClientOriginalName())) 
       {              
          $headings = (new HeadingRowImport)->toArray($file->getClientOriginalName());  
          $data = Excel::import(new PlanillaCapImport($headings,(string) $mes), $file->getClientOriginalName(), 'local', \Maatwebsite\Excel\Excel::XLSX);
          //Excel::import(new AirHspImport, 'ReporteDatoslaboralesNomina1078.xlsx', 'local', \Maatwebsite\Excel\Excel::XLSX);           
           return response()->json([
               "status" => true,
               "data" => $data
           ]); 
       } 
   }

   public function import_cts(Request $request) 
   {
       $data = [];
       $destinationPath = 'uploads';
       $file = $request->file('file');  
       $mes =  $request->input("mes");    
       $file->move(storage_path('app'),$file->getClientOriginalName());
       if (Storage::disk('local')->exists($file->getClientOriginalName())) 
       {              
          $headings = (new HeadingRowImport)->toArray($file->getClientOriginalName());  
          $data = Excel::import(new PlanillaCapCtsImport($headings,(string) $mes), $file->getClientOriginalName(), 'local', \Maatwebsite\Excel\Excel::XLSX);
          //Excel::import(new AirHspImport, 'ReporteDatoslaboralesNomina1078.xlsx', 'local', \Maatwebsite\Excel\Excel::XLSX);           
           return response()->json([
               "status" => true,
               "data" => $data
           ]); 
       } 
   }

   public function planilla_cap_anual(Request $request){
    // $data = DB::select('CALL presupuesto(?)', array('2018'));
    $data=[];
    if ($request->input("planilla")===0) {
        $data =DB::select(DB::raw("CALL sp_planilla_cap_bruto(0)"));  // revisar mes ? estaba con 6    
    }
    if ($request->input("planilla")===2) {
        $data =DB::select(DB::raw("CALL sp_planilla_cap_neto(?)"),array($request->input("mes")));  // revisar mes ? estaba con 6    
    }
    if ($request->input("planilla")===1) {
    $data =DB::select(DB::raw("CALL sp_planilla_cap_bruto(?)"),array($request->input("mes")));  // revisar mes ? estaba con 6    
    }


     return response()->json([       
         'status'  => 1,
         "data" =>$data,
     ]);        
   }

    public function proyeccion_dos_cap(Request $request) {
      // dd($request->input('mes'));                
        $data =DB::select(DB::raw("CALL sp_programacion_cap2(?)"),array($request->input('mes')));  
         return response()->json([       
             'status'  => 1,
             "data" =>$data,
         ]);        
    }
    


}