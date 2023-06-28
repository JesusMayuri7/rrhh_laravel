<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Http\Models\BasePapDetalle;
use App\Http\Models\Escala;
use App\Http\Models\Pap;
use App\Http\Models\Estado;
use App\Http\Models\Area;
use App\Http\Models\Organo;
use App\Http\Models\BaseCAP;
use App\Http\Models\Unidad;
use App\Http\Models\SigaNetCap;
use App\Exports\CapRptExport;
use App\Http\Models\Dependencia;
use App\Http\Models\Matriz;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;
use App\Imports\PersonalCasImport;

class CapController extends BaseController
{
   public function index($cap_id) {
    $cap = DB::select(DB::raw("CALL sp_cap_impresion(?)"),[$cap_id]);
    $estado = Estado::get();
    return response()->json([
        "status" => true,
        "cap" =>$cap,
        "estado" => $estado
    ]);       
   }

   public function base_cap_update(Request $request){     
       
    try {
            $result=DB::transaction(function () use ($request) {
            $data = null;    
            if ($request->input('id.idpap')) {   
                    $data = Pap::where('idpap', $request->input('id.idpap'))->firstOrFail();           
                    if ($request->input('values.meta_id')!==null) {
                        $data->update(["meta_id"=>$request->input('values.meta_id')]);
                    } 
                    elseif ($request->input('values.meta_id2')!==null) {
                        $data->update(["idmeta2"=>$request->input('values.meta_id2')]);
                    }
                    elseif ($request->input('values.estado_pap')!==null) {
                        $data->update(["situacion2"=>$request->input('values.estado_pap')]);
                    }
                    elseif ($request->input('values.org_u_id')!==null) {
                        $data->update(["org_unidad_id"=>$request->input('values.org_u_id')]);
                    }
                    elseif ($request->input('values.org_area_id')!==null) {
                        $data->update(["org_area_id"=>$request->input('values.org_area_id')]);
                    }
                    elseif ($request->input('values.estado_pap')!==null) {
                        $data->update(["situacion2"=>$request->input('values.estado_pap')]);
                    }
                    elseif ($request->input('values.estado_opp')!==null) {
                        $data->update(["estado_opp"=>$request->input('values.estado_opp')]);
                    }
                    elseif ($request->input('values.cargo_pap')!==null) {
                        $data->update(["cargo_pap"=>$request->input('values.cargo_pap')]);
                    }
                    elseif ($request->input('values.eps_aporta')!==null) {
                        $data->update(["eps_aporte"=>$request->input('values.eps_aporta')]);
                    }
                    elseif ($request->input('values.cargo_judicial')!==null) {
                        $data->update(["cargo_judicial"=>$request->input('values.cargo_judicial')]);
                    }
                    elseif ($request->input('values.monto_judicial')!==null) {
                        $data->update(["monto_judicial"=>$request->input('values.monto_judicial')]);
                    }
                    
                    else 
                    {
                        //$data->update($request->input('values'));
                        if ($request->input('id.pd_id')) {   // relacionar para obtener el idp base_cap_dettalle.pd_id
                            $dataDetalle = BasePapDetalle::where('id', $request->input('id.pd_id'))->firstOrFail();                 
                            if($request->input('values.tipo_ingreso')!==null)
                                $dataDetalle->update(["tipo_ingreso"=>$request->input('values.tipo_ingreso')]);
                            if($request->input('values.detalle')!==null)
                                $dataDetalle->update(["detalle"=>$request->input('values.detalle')]);
                            if($request->input('values.fe_ingreso')!==null)
                                $dataDetalle->update(["fe_ingreso"=>$request->input('values.fe_ingreso')]);
                            if($request->input('values.doc_ingreso')!==null)
                                $dataDetalle->update(["doc_ingreso"=>$request->input('values.doc_ingreso')]);
                            if($request->input('values.tipo_ingreso')!==null)
                                $dataDetalle->update(["tipo_ingreso"=>$request->input('values.tipo_ingreso')]);
                            if($request->input('values.tipo_salida')!==null)
                                $dataDetalle->update(["tipo_salida"=>$request->input('values.tipo_salida')]);
                            if($request->input('values.fe_salida')!==null)
                                $dataDetalle->update(["fe_salida"=>$request->input('values.fe_salida')]);
                            if($request->input('values.doc_salida')!==null)
                                $dataDetalle->update(["doc_salida"=>$request->input('values.doc_salida')]);
                            if($request->input('values.fin_licencia')!==null)
                                $dataDetalle->update(["fin_licencia"=>$request->input('values.fin_licencia')]);
                            if($request->input('values.doc_licencia')!==null)
                                $dataDetalle->update(["doc_licencia"=>$request->input('values.doc_licencia')]);
                            if($request->input('values.nombres')!==null)
                                $dataDetalle->update(["nombres"=>$request->input('values.nombres')]);                            
                            //$dataDetalle->save();
                        }
                        elseif ($request->input('values.detalle')!==null) {
                            $data->update(["detalle"=>$request->input('values.detalle')]);
                        }
                    }
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
                   "data" =>$request->input(),
                   "message"=>"error al agregar convocatoria",
                   "log"=>"erro transaccion"
               ],500);
       }
   }

   public function base_cap() {
    $cap = DB::select(DB::raw("SELECT * FROM pap_impresion_pvn"));        
    return response()->json([
        "status" => true,
        "data" =>$cap,        
    ]);       
   }

   public function base_cap_anio($anio) {
    $cap = BaseCAP::where(['anio'=>$anio])->get();        
    return response()->json([
        "status" => true,
        "message" => "Base CAP",
        "data" =>$cap,        
    ]);       
   }

   public function base_cap_id($cap_id) {
    $cap = DB::select(DB::raw("CALL sp_pap_impresion(?)"),[$cap_id]);        
    return response()->json([
        "status" => true,
        "data" =>$cap,        
    ]);       
   }

   public function dependencias() {
    $organo =Organo::get();
    $unidad = Unidad::get();
    $area = Area::where('id','>=',61)->get();   
    $unidad2 = Unidad::where('org_direccion_id','>=',11)->get();   
    return response()->json([
        "status" => true,
        "organos" =>$organo,
        "unidades" => $unidad,
        "unidades2" => $unidad2,
        "areas" => $area,
    ]);  
   }


   public function siga_net_cap() {
    $data =SigaNetCap::get();
    return response()->json([
        "status" => true,
        "data" =>$data
    ]);  
   }

   public function matriz_control(Request $request) {
    $data =DB::select(DB::raw("CALL sp_matriz_control(?)"),[$request->input('idpap')]);
    return response()->json([
        "status" => true,
        "data" =>$data
    ]);       
   }

   public function escala(){
    $data =Escala::get();
    return response()->json([
        "status" => true,
        "data" =>$data
    ]);    
   }

   public function estados(){
    $data =Estado::get();
    return response()->json([
        "status" => true,
        "data" =>$data
    ]);    
   }

   public function area(){
    $data =Area::get();
    return response()->json([
        "status" => true,
        "data" =>$data
    ]);    
   }

   public function unidad(){
    $data =Unidad::get();
    return response()->json([
        "status" => true,
        "data" =>$data
    ]);    
   }
   
   public function matriz_data(){
    $area =Area::get();
    $escala =Escala::get();
    $estado = Estado::get();
    return response()->json([
        "status" => true,
        "area" =>$area,
        "escala" =>$escala,
        "estado" => $estado
    ]);    
   }

   public function nuevo_matriz(Request $request){
    try {
        $result=DB::transaction(function () use ($request) {
        if ($request->input('id')) {   
            $data = Matriz::find($request->input('id'));            
        } else {
            $data = new Matriz;            
        }
        $data->idpap = $request->input('idpap');
        $data->nro_documento = $request->input('nro_documento');
        $data->fecha_documento =substr($request->input('fecha_documento'),0,10);
        $data->nro_documento_fin = $request->input('nro_documento_fin');
        $data->fecha_documento_fin =$request->input('fecha_documento_fin') ? substr($request->input('fecha_documento_fin'), 0, 4) : null;
        $data->detalle = $request->input('detalle');
        $data->dni = $request->input('dni');
        $data->idtrabajador = $request->input('idtrabajador');
        $data->nombres = $request->input('nombres');
        $data->escala_id = $request->input('escala.id');
        $data->inicio = $request->input('inicio');
        $data->fin = $request->input('fin');
        $data->modalidad = $request->input('modalidad');
        $data->tipo_contrato = $request->input('tipo_contrato.value');
        $data->estado = $request->input('estado.situacion');
        $data->org_area_id = $request->input('area.id');
        $data->save();
        $pap = Pap::find($request->input('idpap'));    
        $pap->idestado = $request->input('estado.id');
        if ($request->input('pap')==true)
        {
            $pap->idtrabajador = $request->input('idtrabajador');
            $pap->dni = $request->input('dni');
            $pap->nombres = $request->input('nombres');
        }
        $pap->save();
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
                    "message"=>"error al agregar subsidio",
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

    public function cap_baja(Request $request){
        try {
            $result=DB::transaction(function () use ($request) {
                $data = null;
                if ($request->input('pd_id')) {   
                    $data = BasePapDetalle::where('id', $request->input('pd_id'))->firstOrFail();                 
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

    public function pap_alta(Request $request){
        try {
            $result=DB::transaction(function () use ($request) {
                $data = null;
                if ($request->input('idpap')) {   
                    $data = new BasePapDetalle;                 
                    $data->pap_id = $request->input('idpap');
                    $data->codigo_plaza = $request->input('codigo_plaza');                
                    $data->plaza = $request->input('plaza');                
                    $data->fuente_id = $request->input('fuente_id');                
                    $data->meta_id = $request->input('meta_id');                
                    $data->monto = $request->input('monto_escala') ?? 0; 
                    $data->dependencia_id = $request->input('dependencia_id');                
                    $data->monto_siga = $request->input('monto_siga') ?? 0;                
                    $data->dni = $request->input('nu_dociden');                
                    $data->nombres = $request->input('nombres');                
                    $data->id_personal = $request->input('id_personal');                
                    $data->tipo_ingreso = $request->input('tipo_ingreso');                
                    $data->fe_ingreso = $request->input('fe_ingreso');
                    $data->detalle = $request->input('detalle');   
                    $data->org_unidad_id = $request->input('org_unidad_id');   
                    $data->org_area_id = $request->input('org_area_id'); 
                    $data->estado = 'OCUPADO';   
                    $data->save();
                }
               return $data;
               });
               return response()->json([
                   "status" => true,
                   "data" =>$result,
                   "message"=>"Alta realizada correctamente",
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
    
}