<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Http\Models\PresupuestoDB;
use App\Http\Models\Pea;
use App\Exports\PresupuestoExport;
use App\Imports\PresupuestoImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class ReporteController extends BaseController
{
   public function index($mes){
   // $data = DB::select('CALL presupuesto(?)', array('2018'));
   $data =collect(DB::select(DB::raw("CALL sp_proyeccion_presupuestal_cap(:mes)"),['mes'=>$mes]));  // revisar mes ? estaba con 6
   $pea = Pea::get();
    return response()->json([       
        "data" =>$data,
        'peas'  =>$pea
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


   public function import(Request $request) 
   {
        $destinationPath = 'uploads';
        $file = $request->file('file');

       /* if(!Storage::disk('local')->put($file->getClientOriginalName(), $file)) {
            return false;
        }*/
        $file->move(storage_path('app'),$file->getClientOriginalName());
        if (Storage::disk('local')->exists($file->getClientOriginalName())) 
        {
            \App\Http\Models\PresupuestoDB::query()->delete();
            Excel::import(new PresupuestoImport, $file->getClientOriginalName(), 'local', \Maatwebsite\Excel\Excel::XLS);
            return response()->json([
                "status" => true,
                "data" => PresupuestoDB::count()
            ]); 
        }
       
        

       //(new OrdenImport)->import('ordenes.XLS', 'local', \Maatwebsite\Excel\Excel::XLSX);       
      // return redirect('/')->with('success', 'All good!');
   }
    //

    public function rpt_cantidad_modalidad(Request $request){
        $data = DB::select('SELECT * FROM rpt_cantidad_modalidad' );
        return response()->json([
            "status" => $request,
            "data" =>$data
        ]);
    }
}