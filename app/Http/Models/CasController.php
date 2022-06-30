<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Publicacion;
use App\Http\Models\Convocatoria;
use App\Exports\CapRptExport;
use App\Http\Models\BaseCas;
use App\Http\Models\BaseCasDB;
use App\Http\Models\Unidad;
use App\Http\Models\Solicitud;
use App\Http\Models\SolicitudDetalle;
use App\Http\Models\Meta;
use App\Http\Models\SigaNet;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;

class CasController extends BaseController
{
   public function index() {
    $cap = DB::select(DB::raw("CALL sp_cap(2019)"));
    $estado = Estado::get();
    return response()->json([
        "status" => true,
        "cap" =>$cap,
        "estado" => $estado
    ]);       
   }

   public function certificacion() {
    $certi = DB::select(DB::raw("SELECT * FROM v_certificacion"));    
    return response()->json([
        "status" => true,
        "data" =>$certi,        
    ]);      
}

public function lista_publicacion() {
    $certi = DB::select(DB::raw("SELECT * FROM v_publicacion"));    
    return response()->json([
        "status" => true,
        "data" =>$certi,        
    ]);      
}

    public function certificacion_create(Request $request) {    
       
        try {
            $campos = $request->input("values");        
            $lines=[];
            foreach($campos as $a){
                $lines[]= new SolicitudDetalle(
                    ["codigo_plaza" => $a["codigo_plaza"],
                     "cargo" => $a["cargo"],
                     "dependencia" => $a["desc_unidad"],
                     "monto" => $a["honorario_mensual"],
                    ]);
            }

            $soli = new Solicitud;
            $soli->expediente = $request->input("expediente");            
            $soli->save();
          
            
            //$detalle = new SolicitudDetalle($lines);                
            $soli->solicitudDetalle()->saveMany($lines);
            
         
            //$soli->solicitudDetalle()->update($request->input("values"));
          //  $soli->
          //  $certi = DB::select(DB::raw("SELECT * FROM v_certificacion where id=?"),[$shop->id]);    
            return response()->json([
            "status" => true,
            "data" =>$lines,        
            ]);       
        } catch (\Throwable $th) {
            throw $th;
        }    
    }

    public function certificacion_update(Request $request) {    
        $shop = SolicitudDetalle::find($request->input("id")); 
        try {
            $shop->solicitud()->update(["solicitud"=>$request->input("values.solicitud"),"respuesta"=>$request->input("values.respuesta")]);   
            $certi = DB::select(DB::raw("SELECT * FROM v_certificacion where id=?"),[$shop->id]);    
            return response()->json([
            "status" => true,
            "data" =>$certi,        
            ]);       
        } catch (\Throwable $th) {
            throw $th;
        }    
    }

   public function certificados() {
    $certi = DB::select(DB::raw("SELECT * FROM v_certificados"));    
    return response()->json([
        "status" => true,
        "data" =>$certi,        
    ]);       
   }

   public function proyeccion_cas(Request $request) {
    $data =DB::select(DB::raw(" CALL sp_proyeccion_cas_2020(?)"),[$request->input('meses')]);
    return response()->json([
        "status" => true,
        "data" =>$data,
        "mes" => $request
    ]);       
   }
  

   public function base_cas() {
    $cap = BaseCas::orderBy('updated_at', 'desc')->get();  
    $unidad =Unidad::get();
    $metas = Meta::whereNotNull('meta_2019')->get();  
    return response()->json([
        "status" => true,
        "data" =>$cap,
        "unidades" => $unidad,
        "metas" => $metas
    ]); 
   }

   public function siga_net_ingresos() {
    $siganet = SigaNet::get();  
    return response()->json([
        "status" => true,
        "data" =>$siganet        
    ]); 
   }

   public function base_cas_update(Request $request){       
    
    try {
    $result=DB::transaction(function () use ($request) {
        if ($request->input('id')) {   
            $data = BaseCasDB::find($request->input('id'));            
        } else {
            $data = new BaseCasDB;            
        }
        //$data->id = $request->input('id');
        $data->org_unidad_id = $request->input('org_unidad_id');
        $data->sede = $request->input('sede');
        $data->meta_id = $request->input('meta_id');
        $data->meta = $request->input('meta');
        $data->cargo = $request->input('cargo');        
        $data->detalle = $request->input('detalle');
        $data->dni = $request->input('dni');
        $data->nombres = $request->input('nombres');
        $data->fuente_id = $request->input('fuente_id');
        $data->monto = $request->input('monto');             
        $data->proyectar = $request->input('proyectar');             
        $data->prioridad = $request->input('prioridad');             
        $data->meses = $request->input('meses');             
        $data->save();
        $data['meta_2019']=Meta::select('meta_2019')->where('idmeta_anual',$request->input('meta_id'))->get();       
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
                   "status" => true,
                   "data" =>$result,
                   "message"=>"error al agregar convocatoria",
                   "log"=>"erro transaccion"
               ],500);
       }
   }

   public function matriz_control(Request $request) {
    $data =DB::select(DB::raw("CALL sp_matriz_control(?)"),[$request->input('idpap')]);
    return response()->json([
        "status" => true,
        "data" =>$data
    ]);       
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
                    "status" => true,
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
                       "status" => true,
                       "data" =>$result,
                       "message"=>"error al agregar convocatoria",
                       "log"=>"erro transaccion"
                   ],500);
           }
       }

   public function cap_rpt_vigente() 
    {
        //header('charset', 'utf-8');
        $data= Excel::download(new CapRptExport(), 'Personal_Vigente_Cap.xlsx');
        return $data;
        //return (new PresupuestoExport())->download('invoices.xlsx');
        //$contents = Excel::raw(new PresupuestoExport, 'users.xlsx');
       // return $contents;
        //return Excel::download(new PresupuestoExport(), 'users.xlsx');
    }
    
}