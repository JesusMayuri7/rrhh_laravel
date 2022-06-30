<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Http\Models\AirHspDB;
use App\Http\Models\AirHsp;
use App\Http\Models\Unidad;
use App\Http\Models\AirHspCas;
use App\Imports\AirHspImport;
//use Maatwebsite\Excel\Facades\Excel;
use Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class AirHspController extends BaseController
{
   public function index() {
    $data =AirHsp::get();
        return response()->json([
            "status" => true,
            "data" =>$data
        ]);       
   }
   
   public function index_cas() {
    $data =AirHspCas::get();
    $unidades =Unidad::get();
        return response()->json([
            "status" => true,
            "data" =>$data,
            'unidades'=> $unidades
        ]);       
   }

   public function import(Request $request) 
   {
       $data = [];
       $destinationPath = 'uploads';
       $file = $request->file('file');      
       $file->move(storage_path('app'),$file->getClientOriginalName());
       if (Storage::disk('local')->exists($file->getClientOriginalName())) 
       {
           \App\Http\Models\AirHspDB::truncate();
           \App\Http\Models\AirHspCodigosDB::truncate();
           Excel::import(new AirHspImport, $file->getClientOriginalName(), 'local', \Maatwebsite\Excel\Excel::XLSX);
          //Excel::import(new AirHspImport, 'ReporteDatoslaboralesNomina1078.xlsx', 'local', \Maatwebsite\Excel\Excel::XLSX);           
           return response()->json([
               "status" => true,
               "data" => $data
           ]); 
       } 
   }

}