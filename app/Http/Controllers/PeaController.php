<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Pea;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;

class PeaController extends BaseController
{
   public function index() {
    // $data = Pea::get();
   // $data = DB::select('select * from presupuestodet3');
  


   $data =Pea::get();
    return response()->json([
        "status" => true,
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