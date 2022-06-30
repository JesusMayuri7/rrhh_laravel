<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Meta;
use App\Http\Models\PersonalFormativa;
use App\Imports\PersonalFormativaImport;
//use Maatwebsite\Excel\Facades\Excel;
use Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class PersonalFormativaController extends BaseController
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
          \App\Http\Models\PersonalFormativa::query()->delete();   
          $data = Excel::import(new PersonalFormativaImport($request->input("mes")), $file->getClientOriginalName(), 'local', \Maatwebsite\Excel\Excel::XLS);
          //Excel::import(new AirHspImport, 'ReporteDatoslaboralesNomina1078.xlsx', 'local', \Maatwebsite\Excel\Excel::XLSX);           
           return response()->json([
               "status" => true,
               "data" => $data
           ]); 
       } 
   }

   
    

}