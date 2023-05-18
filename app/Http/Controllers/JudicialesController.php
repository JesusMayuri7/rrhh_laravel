<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\JudicialesDB;
use App\Http\Models\JudicialesDetailDB;
use App\Http\Models\JudicialesV;

class JudicialesController extends Controller
{
    public function create(Request $request){
        if ($request->input('id')) {   
            $documento = JudicialesDB::find($request->input('id'));            
        } else {
            $documento = new JudicialesDB;            
        }             
        $documento->anio = $request->anio;
        $documento->dni = $request->dni;
        $documento->nombres = $request->nombres;
        $documento->org_area_id = $request->org_area_id;
        $documento->monto_judicial = $request->monto_judicial;
        $documento->monto_planilla = $request->monto_planilla;
        $documento->meta_id = $request->meta_id;
        $documento->cargo = $request->cargo;
        $documento->presupuesto = $request->presupuesto;
        $documento->fuente_id = $request->fuente_id;
        $documento->estado_procesal = $request->estado_procesal;
        $documento->nro_expediente_judicial = $request->nro_expediente_judicial;
        $documento->nro_medida_cautelar = $request->nro_medida_cautelar;
        $documento->documento_orh = $request->documento_orh;
        $documento->detalle = $request->detalle;
        $documento->nro_cap = $request->nro_cap;
        $documento->codigo_plaza = $request->codigo_plaza;
        $documento->expediente_pvn = $request->expediente_pvn;
        $documento->expediente_mtc = $request->expediente_mtc;
        $documento->expediente_mef = $request->expediente_mef;
        $documento->fecha_ingreso = $request->fecha_ingreso;
        $documento->observacion = $request->observacion;

        $documento->save();
        $documentoV = JudicialesV::where(['id'=>$documento->id])->first();
        return response()->json([
            "status" => true,
            "data" =>$documentoV,
            "message"=>"Listados de Judiciales",
            "log"=>"listar Judiciales"
        ],200,
        ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }

        public function create_detail(Request $request){
        if ($request->input('id')) {   
            $documento = JudicialesDetailDB::find($request->input('id'));            
        } else {
            $documento = new JudicialesDetailDB;            
        }                     
        $documento->detalle = $request->detalle;
        $documento->nro_documento = $request->nro_documento;        
        $documento->expediente_pvn = $request->expediente_pvn;
        $documento->fecha_expediente_pvn = $request->fecha_expediente_pvn;        
        $documento->judicial_id = $request->judicial_id;

        $documento->save();
        $documentoV = JudicialesDetailDB::where(['id'=>$documento->id])->first();
        return response()->json([
            "status" => true,
            "data" =>$documentoV,
            "message"=>"Judicial detalle agregado",
            "log"=>"new judicial detail"
        ],200,
        ['Content-Type' => 'application/json;charset=UTF-8', 'Charset' => 'utf-8'], JSON_UNESCAPED_UNICODE);
    }


    public function list(Request $request){
        $documentos = JudicialesV::get();        
        return response()->json([
            "status" => true,
            "data" =>$documentos,
            "message"=>"Listados de Judiciales",
            "log"=>"listar judiciales"
        ]);
        
    }
}
