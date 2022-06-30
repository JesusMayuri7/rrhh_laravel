<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Models\VSubsidioDevolucion;
use App\Http\Models\Subsidio;


class SubsidioController extends Controller
{

    
    public function index(){
        $data = DB::select("SELECT s.id,ts.desc_tipo AS tipo,t.idtrabajador,t.dni,t.nombres,inicio,fin,ABS(DATEDIFF(fin, inicio)+1) dias,
        certificado,papeleta,expediente,detalle,ts.id as idtipo FROM
        subsidios s LEFT JOIN tipo_subsidio ts ON ts.id=s.idtipo LEFT JOIN trabajador t ON t.idtrabajador=s.idtrabajador
        ORDER BY s.id DESC");
        return response()->json([
            "status" => true,
            "message" => 'Subsidio',
            "data" =>$data
        ]);
    }

    public function getDevolucion($anio){
        $data = VSubsidioDevolucion::where(['anio'=>$anio])->get();
        return response()->json([
            "status" => true,
            "message" => 'Tipo Subsidio',
            "data" =>$data
        ]);
    }

    public function tipos(){
        $data = DB::select("SELECT id,desc_tipo FROM tipo_subsidio");
        return response()->json([
            "status" => true,
            "message" => 'Tipo Subsidio',
            "data" =>$data
        ]);
    }


    public function newSubsidio(Request $request) 
    {
         try {
             $result=DB::transaction(function () use ($request) {
             if ($request->input('id')>0) {   
                 $data = Subsidio::find($request->input('id'));            
             } else {
                 $data = new Subsidio;            
             }            
             //$data->anio = $request->input('anio');                                            
            // $data->certificado_id = $request->input('certificadoId');
            $data->modalidad_id = $request->input('modalidadId');                        
            $data->certificado_id = $request->input('certificadoId');
            $data->fuente_id = $request->input('fuenteId');
            $data->meta_id = $request->input('metaId');            
             $data->codigo_plaza = $request->input('codigoPlaza');
             $data->codigo_siga = $request->input('codigoSiga');
             $data->dni = $request->input('dni');
             $data->nombres = $request->input('nombres'); 
             
             $data->expediente = $request->input('expediente');                                    
             $data->fecha_devolucion = $request->input('fechaDevengado'); 
             $data->monto_devolucion = $request->input('monto'); 
             $data->clasificador_id = $request->input('clasificadorId');                                    
             $data->estado = $request->input('estado');                                    
             $data->save();             
             $liquidacionCas = VSubsidioDevolucion::where(['id'=>$data->id])->orderBy('id', 'DESC')->get();
             return $liquidacionCas;
             });
             return response()->json([
                 "status" => true,
                 "data" =>$result,
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

    public function crear(Request $request) {
        try {
        $result=DB::transaction(function () use ($request) {
        if ($request->input('id')) {   
            $data = Subsidio::find($request->input('id'));
            $data->idtrabajador = $request->input('idtrabajador');
        } else {
            $data = new Subsidio;
            $data->idtrabajador = $request->input('idtrabajador');
        }
        $data->idtipo = $request->input('idtipoSubsidio.id');
        $data->inicio = $request->input('inicio');
        $data->fin = $request->input('fin');
        $data->certificado = $request->input('certificado');
        $data->papeleta = $request->input('papeleta');
        $data->expediente = $request->input('expediente');
        $data->detalle = $request->input('detalle');
        $data->save();
        return $data;
        });
        return response()->json([
            "status" => true,
            "data" =>$result,
            "message"=>"Subsidio agregado",
            "log"=>"transaccion correcta"
            ],201);   
        } catch(Exception $e) {
                return response()->json([
                    "status" => true,
                    "data" =>$result,
                    "message"=>"error al agregar subsidio",
                    "log"=>"erro transaccion"
                ],500);
        }
    }

}