<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Http\Models\DesignacionV;
use App\Http\Models\DesignacionDB;
//use Maatwebsite\Excel\Facades\Excel;
use Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class DesignacionController extends BaseController
{
   public function index($anio) {
    $data = DesignacionV::where(["anio"=>$anio])->orderBy('id', 'DESC')->get();
        return response()->json([
            "status" => true,
            "data" =>$data,
            "message" => 'Personal de Confianza'
        ]);       
   }
   
   public function update(Request $request) {
    
   }

   public function create(Request $request) 
   {

        try {
            $result=DB::transaction(function () use ($request) {
            if ($request->input('id')) {   
                $data = DesignacionDB::find($request->input('id'));            
            } else {
                $data = new DesignacionDB;            
            }            
            $data->doc_designacion = $request->input('doc_designacion');            
            $data->anio = $request->input('anio');            
            $data->doc_cese = $request->input('doc_cese');            
            $data->detalle = $request->input('detalle');
            $data->plaza = $request->input('plaza');
            $data->dni = $request->input('dni');
            $data->trabajador_id = $request->input('trabajador_id');
            $data->nombres = $request->input('nombres');            
            $data->direccion = $request->input('direccion');            
            $data->cargo = $request->input('cargo');            
            $data->inicio = $request->input('inicio');
            $data->fin = ($request->input('fin')=='0000-00-00' || $request->input('fin')=='') ? null: $request->input('fin');
            $data->modalidad = $request->input('modalidad');
            $data->tipo = $request->input('tipo');
            $data->org_area_id = $request->input('area_id');
            $data->save();
            //DesignacionV::where(['id'=>$data->id])->orderBy('id', 'DESC')->get();
            return DesignacionV::where(['id'=>$data->id])->first();
            });
            return response()->json([
                "status" => true,
                "data" =>$result,
                "message"=>"Registro con exito",
                "log"=>"transaccion correcta"
                ],201);   
            } catch(Exception $e) {
                    return response()->json([
                        "status" => false,
                        "data" =>$result,
                        "message"=>"error al agregar designacion",
                        "log"=>"erro transaccion"
                    ],500);
            }  
   }

}