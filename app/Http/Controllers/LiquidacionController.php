<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Http\Models\LiquidacionCas;
use App\Http\Models\LiquidacionReport;
use App\Http\Models\LiquidacionReportSiaf;
use App\Http\Models\LiquidacionDetalleDB;
use App\Http\Models\LiquidacionDB;

use Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class LiquidacionController extends BaseController
{

    
   public function getLiquidacionCas($anio) {
    $data =LiquidacionCas::where(['anio'=>$anio])->get();
        return response()->json([
            "status" => true,
            "message" => 'Listado de Liquidaciones',
            "data" =>$data
        ]);       
   }

   public function getLiquidacionReport($anio) {
    $data =LiquidacionReport::where(['anio'=> $anio])->get();
        return response()->json([
            "status" => true,
            "message" => 'Reporte de Liquidaciones',
            "data" =>$data
        ]);       
   }

   public function getLiquidacionReportSiaf($anio) {
    $data =LiquidacionReportSiaf::where(['anio'=>$anio])->get();
        return response()->json([
            "status" => true,
            "message" => 'Reporte de Liquidaciones',
            "data" =>$data
        ]);       
   }

   public function getLiquidacionResumenLiquidacion(Request $request){
    $liquidacionResumenCas = DB::select(DB::raw("CALL sp_liquidacion_resumen_liquidacion(?,?,?)"),[$request->input('anio'),$request->input('dscClasificador'),$request->input('dscCertificado')]);    
    return response()->json([
        "status" => true,
        "data" =>$liquidacionResumenCas,
        "message" => 'Resumen de Liquidacion'
    ]);  
   }

   public function getLiquidacionResumenSiaf(Request $request){
    $liquidacionResumenCas = DB::select(DB::raw("CALL sp_liquidacion_resumen_siaf(?,?,?)"),[$request->input('anio'),$request->input('dscClasificador'),$request->input('dscCertificado')]);    
    return response()->json([
        "status" => true,
        "data" =>$liquidacionResumenCas,
        "message" => 'Resumen del Siaf'
    ]);  
   }

   public function updateLiquidacionDetelle(Request $request){
    try {
        $result=DB::transaction(function () use ($request) {
            $data = null;
            if ($request->input('liquidacion_detalle_id')) {   
                $data = LiquidacionDetalleDB::where('id', $request->input('liquidacion_detalle_id'))->firstOrFail();                 
                    $data->update([ $request->input('dscMonto')=>$request->input('monto')]);
                }                            
                return $data;
            } 
           );
           return response()->json([
               "status" => true,
               "data" =>$result,
               "message"=>"Registro con exito",               
               ],201);   
           } catch(Exception $e) {
                   return response()->json([
                       "status" => true,
                       "data" =>$result,
                       "message"=>"error al agregar convocatoria",                       
                   ],500);
           }    
   }

   public function updateLiquidacion(Request $request){
    try {
        $result=DB::transaction(function () use ($request) {
            $data = null;
            if ($request->input('liquidacion_id')) {   
                $data = LiquidacionDB::where('id', $request->input('liquidacion_id'))->firstOrFail();                 
                    $data->update([ $request->input('campo')=>$request->input('valor')]);
                $data = LiquidacionCas::where('id',$data->id)->get();  
                }                            
                return $data;
            } 
           );
           return response()->json([
               "status" => true,
               "data" =>$result,
               "message"=>"Registro con exito",               
               ],201);   
           } catch(Exception $e) {
                   return response()->json([
                       "status" => false,
                       "data" =>$result,
                       "message"=>"error al agregar convocatoria",                       
                   ],500);
           }    
   }

   public function create(Request $request) 
   {
        try {
            $result=DB::transaction(function () use ($request) {
            if ($request->input('id')>0) {   
                $data = LiquidacionDB::find($request->input('id'));            
            } else {
                $data = new LiquidacionDB;            
            }            
            $data->anio = $request->input('anio');                                            
           // $data->certificado_id = $request->input('certificadoId');
            $data->codigo_plaza = $request->input('codigoPlaza');
            $data->codigo_siga = $request->input('codigoSiga');
            $data->fuente_id = $request->input('fuenteId');
            $data->meta_id = $request->input('metaId');            
            $data->dni = $request->input('dni');
            $data->nombres = $request->input('nombres');                                    
            $data->expediente = $request->input('expediente');                                    
            $data->modalidad_id = $request->input('modalidadId');                        
            $data->save();
            $campos = $request->input("liquidacionDetalle");                            
            foreach($campos as $a){
                $item = new LiquidacionDetalleDB();

                $item->liquidacion_id = $data->id;
                $item->clasificador_id = $a["id"];                
                $item->monto_certificado = $a["montoCertificado"];            
                $item->save();
                } 
            $liquidacionCas = LiquidacionCas::where(['id'=>$data->id])->orderBy('id', 'DESC')->get();
            return $liquidacionCas;
            });
            return response()->json([
                "status" => true,
                "data" =>$request->input(),
                "message"=>"Registro con exito",
                "log"=>"transaccion correcta"
                ],201);   
            } catch(Exception $e) {
                    return response()->json([
                        "status" => true,
                        "data" =>$result,
                        "message"=>"error al agregar designacion",
                        "log"=>"erro transaccion"
                    ],500);
            }  
   }

}