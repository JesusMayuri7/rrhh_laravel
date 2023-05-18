<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Publicacion;
use App\Http\Models\Convocatoria;
use App\Exports\CapRptExport;
use App\Http\Models\BaseCas;
use App\Http\Models\BaseCasDB;
use App\Http\Models\CertificacionDB;
use App\Http\Models\Unidad;
use App\Http\Models\Meta;
use App\Http\Models\SigaNet;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;
use App\Http\Models\Solicitud;
use App\Http\Models\SolicitudDetalle;

class CertificacionController extends BaseController
{
   public function validar(Request $request) {
    $data =DB::select(DB::raw("CALL sp_certificacion_cas_validar(?)"),[$request->input('codigo_plaza')]);        
    return response()->json([
        "status" => true,
        "data" =>$data,        
    ]);       
   }

   public function certificacion_plazas(Request $request) {
    $data =DB::select(DB::raw("SELECT * FROM v_certificacion_plazas"));        
    $publicacion =DB::select(DB::raw("SELECT * FROM v_publicacion"));        
    return response()->json([
        "status" => true,
        "data" =>$data,
        "publicacion" => $publicacion
        
    ]);       
   }

   public function metas() {
    $metas = Meta::select('idmeta_anual','meta','finalidad')->get();  
    return response()->json([
        "status" => true,
        "metas" => $metas
    ]); 
   }

   public function base_cas() {
    $cap = BaseCas::orderBy('updated_at', 'desc')->get();  
    $unidad =Unidad::get();
    $metas = Meta::get();  
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

       public function certificacion_plaza_update(Request $request){
        try {
                $result=DB::transaction(function () use ($request) {
                $pivot=null;
               if ($request->input("id") && $request->input("publicacion_id") ) {
                    $pivot = SolicitudDetalle::find($request->input("id"));                      
                    $pivot->publicacion()->sync([$request->input("publicacion_id") => ['estado' => $request->input("estado_final.estado") ?? 'PENDIENTE',
                                                                                        'dni' => $request->input("dni") ?? null,
                                                                                        'nombres' =>$request->input("nombres") ?? null
                                                                                        ]]);
                }
                return $pivot;
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
                           "message"=>"error al agregar subsidio",
                           "log"=>"erro transaccion"
                       ],500);
              }
    }


    public function update_solicitud(Request $request) {            
     $shop = CertificacionDB::find($request->input("certificacion_id")); 
     try {
        $shop->solicitud = $request->input("solicitud");
        $shop->fecha_solicitud = Carbon::parse($request->input("fecha_solicitud"))->toDateString();
        $shop->save();
        return response()->json([
            "status" => true,
            "data" =>$request->input(),
            "message"=>"Registro con exito",
            "log"=>"transaccion correcta"
            ],201); 
    } catch (\Throwable $th) {
        throw $th;
    }
    } 

       public function certificacion_update(Request $request) {    
         
        $shop = SolicitudDetalle::find($request->input("id")); 
        try {
            $shop->respuesta = $request->input("values.respuesta");
            //$shop->publicacion_id = $request->input("values.publicacion_id");  
            if ($request->input("values.publicacion_id")) {                
                $shop->publicacion()->sync([$request->input("values.publicacion_id")], false);
            }

            if ($request->input("values.publicacion_id")) {                
                $shop->publicacion()->sync([$request->input("values.publicacion_id")], false);
            }            
            if ($request->input("values.modalidad") !== null ) {
                $shop->modalidad = $request->input("values.modalidad");                
            }
            $shop->save();
            if ($request->input("values.solicitud") !== null ) {
                $shop->solicitud()->update(["solicitud"=>$request->input("values.solicitud")]);   
            }
            if ($request->input("values.fecha_solicitud") !== null ) {
                $shop->solicitud()->update(["fecha_solicitud"=> Carbon::parse($request->input("values.fecha_solicitud"))->format('Y-m-d')]);
                //Carbon::createFromFormat('d/m/Y',$request->input("values.fecha_solicitud"))]);
            }
            if ($request->input("values.expediente") !== null) {
                $shop->solicitud()->update(["expediente"=>$request->input("values.expediente")]);   
            }
            if ($request->input("values.tipo") !== null) {
                $shop->solicitud()->update(["tipo"=>$request->input("values.tipo")]);   
            }
            if ($request->input("values.modalidad_concurso") !== null) {                
                $shop->update(["modalidad_concurso" => $request->input("values.modalidad_concurso")] );   
            }       
            if ($request->input("values.sustento_legal") !== null) {                
                $shop->update(["sustento_legal" => $request->input("values.sustento_legal")] );   
            }  
            if ($request->input("values.anulado") !== null) {                
                $shop->update(["anulado" => $request->input("values.anulado")] );   
            }                                   
            return response()->json([
            "status" => true,
            "data" =>$request->input(),        
            ]);       
        } catch (\Throwable $th) {
            throw $th;
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