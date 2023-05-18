<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Publicacion;
use App\Http\Models\Convocatoria;
use App\Exports\CapRptExport;
use App\Http\Models\BaseFormativa;
use App\Http\Models\BaseFormativaDB;
use App\Http\Models\Unidad;
use App\Http\Models\Solicitud;
use App\Http\Models\SolicitudDetalle;
use App\Http\Models\Meta;
use App\Http\Models\SigaNetFormativa;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;

class FormativaController extends BaseController
{
   public function index() {
    
   }


   public function base_formativa_alta_baja(Request $request){     
    
    try {        
        $result=DB::transaction(function () use ($request) {
        $data = [];
        if ($request->input('codigoBaja'))
         {   
           $data =DB::select(DB::raw(" CALL sp_baja_alta_formativa(?,?,?,?)"),[$request->input('anio'),$request->input('fechaBaja'),
           $request->input('codigoBaja'),$request->input('codigoAlta')]);      
           if($data)                 
            $data = BaseFormativa::where(['id'=>$data[0]->id])->first();
        }
        return $data;
       });
       return response()->json([
           "status" => true,
           "data" =>$result,
           "message"=>"Registro con exito",
           "log"=>"transaccion correcta"
           ],200);   
       } catch(Exception $e) {
               return response()->json([
                   "status" =>false,
                   "data" =>$result,
                   "message"=>"error al remover registro",
                   "log"=>"erro transaccion"
               ],500);
       }
   }

   public function base_formativa($anio) {
    $cap = BaseFormativa::orderBy('updated_at', 'desc')->get();  
    $unidad =Unidad::get();
    $metas = Meta::whereNotNull('finalidad')->get();  
    return response()->json([
        "status" => true,
        "data" =>$cap,
        "unidades" => $unidad,
        "metas" => $metas
    ]); 
   }

   public function base_formativa_anio($anio) {
    $cap = BaseFormativa::orderBy('updated_at', 'desc')->where(['anio'=>$anio])->get();  
    //$unidad =Unidad::get();
    //$metas = Meta::whereNotNull('finalidad')->get();  
    return response()->json([
        "status" => true,
        "data" =>$cap,
        "message" => 'Practicantes'
    ]); 
   }

   public function base_formativa_proyeccion_ejec() {
    $data =DB::select(DB::raw(" CALL sp_proyeccion_formativa_ejec()"));    
    return response()->json([
        "status" => true,
        "data" =>$data,        
    ]); 
   }

   public function siga_formativa() {
    $siganet = SigaNetFormativa::get();  
    return response()->json([
        "status" => true,
        "data" =>$siganet        
    ]); 
   }

   public function base_formativa_update(Request $request){       
    
    try {
    $result=DB::transaction(function () use ($request) {
        $data = null;
        if ($request->input('id')) {   
            $data = BaseFormativaDB::where('id', $request->input('id'))->firstOrFail(); 
            if ($request->input('values.idmeta_anual')!==null) {
                $data->update(["meta_id"=>$request->input('values.idmeta_anual')]);
            }
            elseif ($request->input('values.org_unidad_id2')!==null) {
                $data->update(["org_unidad_id2"=>$request->input('values.org_unidad_id2')]);
            }
            else
            $data->update($request->input('values'));
        
        } 
        return $data;
       });
       return response()->json([
           "status" => true,
           "data" =>$request->input(),
           "message"=>"Registro con exito",
           "log"=>"transaccion correcta"
           ],200);   
       } catch(Exception $e) {
               return response()->json([
                   "status" => true,
                   "data" =>$result,
                   "message"=>"error al agregar convocatoria",
                   "log"=>"erro transaccion"
               ],500);
       }
   }

   public function base_formativa_updated(Request $request){       
    
    try {
    $result=DB::transaction(function () use ($request) {
        $data = null;
        if ($request->input('practicanteId')) {   
            $data = BaseFormativaDB::where('id', $request->input('practicanteId'))->firstOrFail();                 
            $data->update([ $request->input('campo')=>$request->input('valor')]);
            $data = BaseFormativa::where('id',$data->id)->first();  
            }                                        
        return $data;
       });
       return response()->json([
           "status" => true,
           "data" =>$result,
           "message"=>"Registro con exito",
           "log"=>"transaccion correcta"
           ],200);   
       } catch(Exception $e) {
               return response()->json([
                   "status" => false,
                   "data" =>$result,
                   "message"=>"error al agregar convocatoria",
                   "log"=>"erro transaccion"
               ],500);
       }
   }



   
   public function nueva_publicacion(Request $request){       
    
     try {
     $result=DB::transaction(function () use ($request) {
         $data = $request->all();
         
         $data=json_decode($request->getContent(), true);
         Publicacion::where(['modalidad'=>$data[0]['modalidad'],'tipo'=>$data[0]['tipo']])->delete();             
        $bien = Publicacion::insert($data);
        return $bien;
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
                    "message"=>"error al agregar subsidio",
                    "log"=>"erro transaccion"
                ],500);
        }
    }

    public function nueva_convocatoria(Request $request){       
    
        try {
        $result=DB::transaction(function () use ($request) {
            if ($request->input('id')) {   
                $data = Convocatoria::find($request->input('id'));            
            } else {
                $data = new Convocatoria;            
            }
            //$data->id = $request->input('id');
            $data->nro_convocatoria = $request->input('nro_convocatoria.nro_convocatoria');
            $data->tipo = $request->input('tipo.value');
            $data->airhsp = str_pad($request->input('airhsp'),4,"0",STR_PAD_LEFT);
            $data->airhsp_id = $request->input('airhsp_id');
            $data->airhsp = $request->input('codigo_plaza');
            $data->detalle = $request->input('detalle');
            $data->certificacion = $request->input('certificacion');
            $data->cargo = $request->input('cargo');
            $data->nuevo = $request->input('nuevo.value');
            $data->org_unidad_id = $request->input('unidad.id');            
            $data->save();
           return $data;
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
                       "message"=>"error al agregar convocatoria",
                       "log"=>"erro transaccion"
                   ],500);
           }
       }


    
}