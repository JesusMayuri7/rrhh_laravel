<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Publicacion;
use App\Http\Models\Convocatoria;
use App\Exports\CapRptExport;
use App\Http\Models\BaseCas;
use App\Http\Models\BaseCasDB;
use App\Http\Models\BaseCasDetalle;
use App\Http\Models\CertificacionDetallePublicacion;
use App\Http\Models\Unidad;
use App\Http\Models\Solicitud;
use App\Http\Models\SolicitudDetalle;
use App\Http\Models\Meta;
use App\Http\Models\SigaNet;
use App\Http\Models\PersonalCas;
use App\Imports\PersonalCasImport;

//use Maatwebsite\Excel\Facades\Excel;
use Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

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

    public function certificacion_create(Request $request) {    
       
        try {
            $result=DB::transaction(function () use ($request) {
            $campos = $request->input("values");        
            $lines=[];
            foreach($campos as $a){
                $lines[]= new SolicitudDetalle(
                    ["codigo_plaza" => $a["codigo_plaza"],
                     "cargo" => $a["cargo"],
                     "dependencia" => $a["area"]["desc_area"],
                     "area_id" => $a["area"]["id"],
                     "monto" => $a["honorario_mensual"],                     
                     "anio"=>"2023",
                     "modalidad_concurso" => $a["modalidad_conv"]["label"],                     
                     "sustento_legal" => $a["sustento_conv"]["label"],                     
                    ]);
            }
            $soli = new Solicitud;
            $soli->expediente = $request->input("expediente");            
            $soli->save();                      
            $detalle = new SolicitudDetalle($lines);                
            $soli->solicitudDetalle()->saveMany($lines);
            return $soli;  
        });
            return response()->json([
            "status" => true,
            "data" =>$result,        
            ]);   
                
        } catch (Exception $e) {
            return response()->json([
                "status" => true,
                "message"=> $e,
                "data" =>[],        
            ],500);   
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

   


   public function base_cas($anio) {
    $cap = BaseCas::orderBy('updated_at', 'desc')->where(['anio'=>$anio])->get();  
    $unidad =Unidad::get();
    $metas = Meta::whereIn('presupuesto',['SEDE','PEAJE','ZONAL'])->get();  
    $metas2 = DB::select(DB::raw("SELECT * FROM v_metas2"));    
    $unidades2 = DB::select(DB::raw("SELECT * FROM org_unidad where org_direccion_id>=11"));    
    return response()->json([
        "status" => true,
        "data" =>$cap,
        "unidades" => $unidad,
        "metas" => $metas,
        "metas2" => $metas2,
        "unidades2" => $unidades2
    ]); 
   }

   public function base_cas_proyeccion($anio) {
 
    $data =DB::select(DB::raw("SELECT * from v_base_cas_proyeccion where anio=?"),[$anio]); 
    return response()->json([
        "status" => true,
        "data" =>$data,
        "message" => 'Base Cas Proyeccion'
    ]); 
   }

   public function base_cas_historial($base_cas_id) {
 
    $data =DB::select(DB::raw("CALL sp_historial_cas(?)"),[$base_cas_id]);
    return response()->json([
        "status" => true,
        "data" =>$data,
        "message" => 'Base Cas Historial'
    ]); 
   }

   public function siga_net_ingresos() {
    $siganet = SigaNet::get();  
    return response()->json([
        "status" => true,
        "data" =>$siganet        
    ]); 
   }

   public function certificacion_cargo_update(Request $request){           
    try {
    $result=DB::transaction(function () use ($request) {
        if ($request->input('codigo_plaza')) {   
            //$data = BaseCasDB::find($request->input('codigo_plaza'));  
            $data = BaseCasDB::where(['codigo_plaza' => $request->input('codigo_plaza'),'anio'=>2022])->firstOrFail();
        }       
        $data->cargo = $request->input('cargo');
        $data->monto = $request->input('monto');                
        /*$data->org_unidad_id = $request->input('org_unidad_id');        
        $data->meta_id = $request->input('meta_id');
        $data->meta = $request->input('meta');
        $data->detalle = $request->input('detalle');        
        $data->monto = $request->input('monto');                     */
        $data->save();        
       return $data;
       });
       return response()->json([
           "status" => true,
           "data" =>$result,
           "message"=>"Cargo actualizado con exito",
           "log"=>"transaccion correcta"
           ],201);   
       } catch(Exception $e) {
               return response()->json([
                   "status" => false,
                   "data" =>$result,
                   "message"=>"error al actualizar cargo",
                   "log"=>"erro transaccion"
               ],500);
       }
   }

   

   public function base_cas_update(Request $request){            
    try {      
        $result=DB::transaction(function () use ($request) {    
           $data = null;     
        if ($request->input('id.id')) {   
            $data = BaseCasDB::where('id', $request->input('id.id'))->firstOrFail();                             
            //DB::enableQueryLog();            
               if ($request->input('values.meta_id')!==null) {
                   $data->update(["meta_id"=>$request->input('values.meta_id')]);
               }
               elseif ($request->input('values.meta_id2')!==null) {
                $data->update(["meta_id2"=>$request->input('values.meta_id2')]);
               }
               elseif ($request->input('values.org_area_id')!==null) {
                   $data->update(["org_area_id"=>$request->input('values.org_area_id')]);
               }
               elseif ($request->input('values.cargo')!==null) {
                $data->update(["cargo"=>$request->input('values.cargo')]);
               }   
               elseif ($request->input('values.estado_opp')!==null) {
                $data->update(["estado_opp"=>$request->input('values.estado_opp')]);
               } 
               elseif ($request->input('values.codigo_plaza')!==null) {
                $data->update(["codigo_plaza"=>$request->input('values.codigo_plaza')]);
               }  
               elseif ($request->input('values.presupuesto')!==null) {
                $data->update(["presupuesto"=>$request->input('values.presupuesto')]);
               }  
               elseif ($request->input('values.codigo_plaza_ant')!==null) {
                $data->update(["codigo_plaza_ant"=>$request->input('values.codigo_plaza_ant')]);
               }  
               elseif ($request->input('values.sustento_legal')!==null) {
                $data->update(["sustento_legal"=>$request->input('values.sustento_legal')]);
               }      
                else
                {
                    $data->update($request->input('values'));
                    if($request->input('values.nombres')!==null) {
                       // se debe obtener primero base_cas_detalle_id
                        $dataDetalle = BaseCasDetalle::where('id', $request->input('id.base_cas_detalle_id'))->firstOrFail();             
                        $dataDetalle->update(['nombres'=>$request->input('values.nombres')]);
                    }
                    elseif($request->input('values.detalle')!==null)
                    {
                        $dataDetalle = BaseCasDetalle::where('id', $request->input('id.base_cas_detalle_id'))->firstOrFail();             
                        $dataDetalle->update(['detalle'=>$request->input('values.detalle')]);  
                    }
                    elseif($request->input('values.tipo_ingreso')!==null)
                    {
                        $dataDetalle = BaseCasDetalle::where('id', $request->input('id.base_cas_detalle_id'))->firstOrFail();             
                        $dataDetalle->update(['tipo_ingreso'=>$request->input('values.tipo_ingreso')]);  
                    }
                    elseif($request->input('values.tipo_salida')!==null)
                    {
                        $dataDetalle = BaseCasDetalle::where('id', $request->input('id.base_cas_detalle_id'))->firstOrFail();             
                        $dataDetalle->update(['tipo_salida'=>$request->input('values.tipo_salida')]);  
                    }
                    elseif($request->input('values.fe_ingreso')!==null)
                    {
                        $dataDetalle = BaseCasDetalle::where('id', $request->input('id.base_cas_detalle_id'))->firstOrFail();             
                        $dataDetalle->update(['fe_ingreso'=>$request->input('values.fe_ingreso')]);  
                    }
                    elseif($request->input('values.fin_licencia')!==null)
                    {
                        $dataDetalle = BaseCasDetalle::where('id', $request->input('id.base_cas_detalle_id'))->firstOrFail();             
                        $dataDetalle->update(['fin_licencia'=>$request->input('values.fin_licencia')]);  
                    }
                    elseif($request->input('values.doc_salida')!==null)
                    {
                        $dataDetalle = BaseCasDetalle::where('id', $request->input('id.base_cas_detalle_id'))->firstOrFail();             
                        $dataDetalle->update(['doc_salida'=>$request->input('values.doc_salida')]);  
                    }
                    elseif($request->input('values.doc_ingreso')!==null)
                    {
                        $dataDetalle = BaseCasDetalle::where('id', $request->input('id.base_cas_detalle_id'))->firstOrFail();             
                        $dataDetalle->update(['doc_ingreso'=>$request->input('values.doc_ingreso')]);  
                    }
                    elseif($request->input('values.doc_licencia')!==null)
                    {
                        $dataDetalle = BaseCasDetalle::where('id', $request->input('id.base_cas_detalle_id'))->firstOrFail();             
                        $dataDetalle->update(['doc_licencia'=>$request->input('values.doc_licencia')]);  
                    }
                }
        }
                    
        //$data->id = $request->input('id');
        //if ($request->input("values.solicitud") !== null ) {
        //$data->org_unidad_id = $request->input('org_unidad_id');        
        //$data->meta_id = $request->input('meta_id');
        //$data->meta = $request->input('meta');        
        //$data->dni = $request->input('dni');        
        //$data->fuente_id = $request->input('fuente_id');
        //$data->monto = $request->input('monto');             
        //$data->proyectar = $request->input('proyectar');             
        //$data->prioridad = $request->input('prioridad');             
        //$data->meses = $request->input('meses');             
        //$data->save();
        //$data['meta_2019']=Meta::select('meta_2019')->where('idmeta_anual',$request->input('meta_id'))->get();       
       return $data;
       });
       return response()->json([
           "status" => true,
           "data" =>$request->input(),
           "message"=>"Registro con exito",
           "log"=>"pendiente"
           ],201);   
       } catch(Exception $e) {
               return response()->json([
                   "status" => true,
                   "data" =>$request->input(),
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

   public function create_certificacion_detalle_publicacion(Request $request){           
    try {
    $result=DB::transaction(function () use ($request) {               
            $publi = new CertificacionDetallePublicacion();
            $publi->publicacion_id = $request->input('publicacion_id');
            $publi->certificacion_detalle_id = $request->input('certificacion_detalle_id');            
            $publi->save();        
        //$bien = Publicacion::insert($publi);
       return true;
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

   
   public function nueva_publicacion(Request $request){           
     try {
     $result=DB::transaction(function () use ($request) {
         //$data = $request->all();         
         $data=json_decode($request->getContent(), true);
         foreach ($data as $item){
             $publi = Publicacion::updateOrCreate(['modalidad'=>$item['modalidad'],'convocatoria'=>$item['convocatoria'],'anio'=>$item['anio']],             
             [
              'convocatoria'=>$item['convocatoria'],
              'modalidad'=>$item['modalidad'],
              'anio'=>$item['anio'],
             'cargo' => $item['cargo'],
             'lugar_trabajo' => $item['lugar_trabajo'],
             'inscripcion' => $item['inscripcion'],
             'cierre' => $item['cierre'],
             'estado' => $item['estado'],
             'tipo' => $item['tipo'],
             'enlace' => $item['enlace']
             ]
            );
             $publi->save();
         }
         //$bien = Publicacion::insert($publi);
        return true;
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

    public function import_personal_cas(Request $request) 
    {
        $data = [];
        $destinationPath = 'uploads';
        $file = $request->file('file');  
        
        $file->move(storage_path('app'),$file->getClientOriginalName());
        if (Storage::disk('local')->exists($file->getClientOriginalName())) 
        {                   
            \App\Http\Models\PersonalCas::query()->delete();    
           $data = Excel::import(new PersonalCasImport, $file->getClientOriginalName(), 'local', \Maatwebsite\Excel\Excel::XLS);
           //Excel::import(new AirHspImport, 'ReporteDatoslaboralesNomina1078.xlsx', 'local', \Maatwebsite\Excel\Excel::XLSX);           
            return response()->json([
                "status" => true,
                "data" => $data
            ]); 
        } 
    }

    public function lista_designacion() {
        $certi = DB::select(DB::raw("SELECT * FROM v_personal_cas_nuevo"));    
        return response()->json([
            "status" => true,
            "data" =>$certi,        
        ]);       
       }


    public function lista_concurso() {
        $certi = DB::select(DB::raw("SELECT * FROM v_personal_cas_concurso"));    
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

    public function cas_baja(Request $request){
        try {
            $result=DB::transaction(function () use ($request) {
                $data = null;
                if ($request->input('id')) {   
                    $data = BaseCasDetalle::where('id', $request->input('base_cas_detalle_id'))->firstOrFail();                 
                //$data->id = $request->input('id');
                    $data->tipo_salida = $request->input('tipo_salida');                
                    $data->fe_salida = $request->input('fe_salida');
                    $data->detalle = $request->input('detalle');   
                    $data->estado = 'VACANTE';   
                    $data->save();
                }
               return $data;
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
                           "message"=>"error al agregar convocatoria",
                           "log"=>"erro transaccion"
                       ],500);
               }
    }

    public function cas_designacion(Request $request){
        try {
            $result=DB::transaction(function () use ($request) {
                $data = null;
                if ($request->input('id_personal')) {   
                    $data = new BaseCasDetalle;                 
                    $data->base_cas_id = $request->input('base_cas_id');
                    $data->id_personal = $request->input('id_personal');
                    $data->codigo_plaza = $request->input('codigo_plaza');
                    $data->cargo = $request->input('cargo');
                    $data->vigencia = $request->input('fecha_fin_vigencia_cas');
                    $data->tipo_ingreso = $request->input('tipo_ingreso');               
                    $data->dni = $request->input('nu_dociden');
                    $data->monto = $request->input('mt_contmn');
                    $data->nombres = $request->input('nombres');
                    $data->fe_ingreso = $request->input('fe_inicont');
                    $data->meta_id = $request->input('idmeta_anual');
                    $data->org_unidad_id = $request->input('org_unidad_id');
                    $data->detalle = $request->input('detalle');   
                    $data->fe_inicont =$request->input('fe_inicont');   
                    $data->fe_fincont =$request->input('fe_fincont');   
                    $data->estado = 'OCUPADO';   
                    $data->cargo = $request->input('cargo');   
                    $data->save();
                }
               return $data;
               });
               return response()->json([
                   "status" => true,
                   "data" =>$request->input(),
                   "message"=>"Registro con exito",
                   "log"=>"Alta por designacion"
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
 
    public function cas_alta(Request $request) {
        try {
            $result=DB::transaction(function () use ($request) {
                $data = null;
                if ($request->input('id')) {   
                    $data = new BaseCasDetalle;                 
                    $data->base_cas_id = $request->input('id');
                    $data->id_personal = $request->input('id_personal');
                    $data->codigo_plaza = $request->input('codigo_plaza');                    
                    $data->fuente_id = $request->input('fuente_id');                    
                    $data->vigencia = $request->input('fecha_fin_vigencia_cas');
                    $data->tipo_ingreso = $request->input('tipo_ingreso');               
                    $data->dni = $request->input('dni');
                    $data->monto = $request->input('monto');
                    $data->nombres = $request->input('nombres');
                    $data->fe_ingreso = $request->input('fe_ingreso');
                    $data->meta_id = $request->input('meta_id');
                    $data->org_unidad_id = $request->input('org_unidad_id');
                    $data->detalle = $request->input('detalle');   
                    $data->fe_inicont =$request->input('fe_inicont');   
                    $data->fe_fincont =$request->input('fe_fincont');   
                    $data->estado = 'OCUPADO';   
                    $data->cargo = $request->input('cargo');   
                    $data->save();
                }
               return $data;
               });
               return response()->json([
                   "status" => true,
                   "data" =>$result,
                   "message"=>"Registro con exito",
                   "log"=>"Alta por DNI"
                   ],201);   
               } catch(Exception $e) {
                       return response()->json([
                           "status" => true,
                           "data" =>$result,
                           "message"=>"error al agregar registros",
                           "log"=>"erro transaccion"
                       ],500);
               }
    }
 
}