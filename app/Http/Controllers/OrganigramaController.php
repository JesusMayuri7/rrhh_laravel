<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Organigrama;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;

class OrganigramaController extends BaseController
{

    public function index(){
        // $data = DB::select('CALL presupuesto(?)', array('2018'));
        $data =Organigrama::get();
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