<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Documentos;
use App\Imports\DocumentoImport;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Excel;



class DocumentosController extends Controller
{
    public function create(Request $request){
        if ($request->input('id')) {   
            $documento = Documentos::find($request->input('id'));            
        } else {
            $documento = new Documentos;            
        }             
        $documento->tipo = $request->tipo;
        $documento->asunto = $request->asunto;
        $documento->detalle = $request->detalle;
        $documento->expediente_pvn = $request->expediente_pvn;
        $documento->expediente_mef = $request->expediente_mef;
        $documento->expediente_mtc = $request->expediente_mtc;
        $documento->numero_pvn = $request->numero_pvn;
        $documento->fecha = $request->fecha;
        $documento->destino = $request->destino;
        $documento->estado = $request->estado;
        $documento->anio = $request->anio;
        $documento->remite = $request->remite;        
        $documento->save();
        $documentoV = Documentos::where(['id'=>$documento->id])->first();
        return response()->json([
            "status" => true,
            "data" =>$documentoV,
            "message"=>"Listados de Documentos",
            "log"=>"listar documentos"
        ],200); 

    }

    


    public function list(Request $request){
        $documentos = Documentos::orderBy('id','DESC')->get();        
        return response()->json([
            "status" => true,
            "data" =>$documentos,
            "message"=>"Listados de Documentos",
            "log"=>"listar documentos"
        ],200); 
        
    }

    public function import(Request $request) 
    {
        $data = 'empezo';
        $destinationPath = 'uploads';
        //if($request->hasFile('file')){
        $file = $request->file('file'); 

         $file->move(storage_path('app'),$file->getClientOriginalName());
        $rowImported = 0;
        $import = new DocumentoImport($request->anio);
        if (Storage::disk('local')->exists($file->getClientOriginalName())) 
        {           
           $data = Excel::import($import, $file->getClientOriginalName(), 'local', 
           \Maatwebsite\Excel\Excel::XLSX);
           //Excel::import(new AirHspImport, 'ReporteDatoslaboralesNomina1078.xlsx', 'local', \Maatwebsite\Excel\Excel::XLSX);           
           $rowImported = $import->getRowCount();
           return response()->json([
            "status" => true,
            "data" =>$rowImported,
            "message"=>"Registos importados: $rowImported",
            "log"=>"log"
              ],200); 
        }


    }
}  
