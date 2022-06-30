<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Http\Models\AirHspFormativaDB;
use App\Http\Models\AirHspFormativa;
use App\Imports\FormativaAirHspImport;
//use Maatwebsite\Excel\Facades\Excel;
use Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\HeadingRowImport;

class AirHspFormativaController extends BaseController
{
   public function index() {
    $data =AirHspFormativaDB::get();
        return response()->json([
            "status" => true,
            "data" =>$data
        ]);       
   }

   public function airhsp_formativa() {
    $data =AirHspFormativa::get();
        return response()->json([
            "status" => true,
            "data" =>$data
        ]);       
   }


   public function import(Request $request) 
   {
       $data = [];
       $destinationPath = 'uploads';
       $file = $request->file('file');      
       $file->move(storage_path('app'),$file->getClientOriginalName());
       //$headings = (new HeadingRowImport)->toArray($file->getClientOriginalName());         
       //print_r($headings);
       if (Storage::disk('local')->exists($file->getClientOriginalName())) 
       {
           \App\Http\Models\AirHspFormativaDB::truncate();
           Excel::import(new FormativaAirHspImport, $file->getClientOriginalName(), 'local', \Maatwebsite\Excel\Excel::XLSX);
          //Excel::import(new AirHspImport, 'ReporteDatoslaboralesNomina1078.xlsx', 'local', \Maatwebsite\Excel\Excel::XLSX);           
           return response()->json([
               "status" => true,
               "data" => $data
           ]); 
       } 
   }

}