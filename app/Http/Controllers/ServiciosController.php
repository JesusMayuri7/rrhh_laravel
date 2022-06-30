<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Http\Models\Funcional;
use App\Http\Models\Servicios;
use App\Http\Models\ServiciosDB;
use App\Http\Models\Orden;
use App\Http\Models\AreaSigaMef;
use App\Http\Models\ServiciosDetalleDB;
use App\Http\Models\ServiciosDetalle;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;

class ServiciosController extends BaseController
{

    public function index(){
        // $data = DB::select('CALL presupuesto(?)', array('2018'));
        $organigrama =Funcional::with('direcciones.unidades.areas')->get();
        $servicios =Servicios::with('servicios_detalle')->get();
         return response()->json([            
             "organigrama" =>$organigrama,
             "servicios" => $servicios
         ]);         
   }

   public function eliminar_personal($id){
    try {
        $result=DB::transaction(function () use ($id) {
        if ($id) {   
            $data = ServiciosDetalleDB::findOrFail($id);            
            $data->delete();
            return $data;
        }         
        });
        return response()->json([
            "status" => true,
            "data" =>$result,
            "message"=>"Personal eliminado",
            "log"=>"transaccion correcta"
            ],201);   
        } catch(Exception $e) {
                return response()->json([
                    "status" => true,
                    "data" =>$result,
                    "message"=>"error al eliminar servicio",
                    "log"=>"erro transaccion"
                ],500);
        }
    }

   public function orden(Request $request){      
        $where = function ($query) use ($request) {
            if ($request->input('estado'))  {
                 if ($request->input('estado')!='TODOS') {
                    $query->whereRaw("estados = CONVERT(? USING utf8)", [$request->input('estado')]);
                    }
            }
            if ($request->input('parametro')=='orden') {
                    $query->where('orden',$request->input('valor'));
                }
            if ($request->input('parametro')=='nro_pedido') {
                    $query->where('nro_pedido',$request->input('valor'));
                }
            if ($request->input('parametro')=='nombre_prov') {
                    $query->where('nombre_prov','LIKE','%'.$request->input('valor').'%');
                }
            if ($request->input('parametro')=='dsc_orden') {
                    $query->where('dsc_orden','LIKE','%'.$request->input('valor').'%');
                }
            if ($request->input('parametro')=='nro_ruc') {
                    $query->where('nro_ruc',$request->input('valor'));
                }
            if ($request->input('centro_costo'))  {
                if ($request->input('centro_costo')!='TODOS') {
                        $query->where('centro_costo',$request->input('centro_costo'));
                }
            }
            if ($request->input('control')) {
                if ($request->input('control')!='TODOS') {
                        $query->where('control',$request->input('control'));
                    }
            }
            if ($request->input('condicion')) {
                if ($request->input('condicion')!='TODOS') {
                        $query->where('condicion',$request->input('condicion'));
                    }
            }
        //    dd($query);
        };
    
     $data = Orden::where($where)->orderBy('anio', 'desc')->orderBy('orden', 'desc')
     ->paginate(100, ['*'], 'page', 0);
     $zonales = AreaSigaMef::get();
     return response()->json([                     
         "orden" => $data,
         'zonales' => $zonales
      ]);      
}

   public function nuevo_personal(Request $request){
    try {
        $result=DB::transaction(function () use ($request) {
        if ($request->input('id')) {   
            $data = ServiciosDetalleDB::find($request->input('id'));            
        } else {
            $data = new ServiciosDetalleDB;            
        }
        $data->servicios_id = $request->input('servicio_id');
        $data->nro_pedido = $request->input('nro_pedido');
        $data->orden = $request->input('orden');
        $data->mensual = $request->input('mensual');
        $data->total = $request->input('total');
        $data->tiempo_servicio = $request->input('tiempo_servicio');
        $data->servicio = $request->input('servicio');
        $data->inicio = $request->input('inicio');
        $data->expediente = $request->input('expediente');
        $data->detalle = $request->input('detalle');
        $data->save();
        return $data;
        });
        return response()->json([
            "status" => true,
            "data" =>ServiciosDetalle::find($result->id),
            "message"=>"Servicio agregado",
            "log"=>"transaccion correcta"
            ],201);   
        } catch(Exception $e) {
                return response()->json([
                    "status" => true,
                    "data" =>$result,
                    "message"=>"error al agregar servicio",
                    "log"=>"erro transaccion"
                ],500);
        }
    }

    public function nuevo_servicio(Request $request){         

        try {
            $result=DB::transaction(function () use ($request) {
            if ($request->input('id')) {   
                $data = ServiciosDB::find($request->input('id'));            
            } else {
                $data = new ServiciosDB;            
            }
            $data->autorizacion = $request->input('autorizacion');
            $data->condicion = $request->input('condicion');            
            $data->servicio = $request->input('servicio');            
            $data->detalle = $request->input('detalle');            
            $data->org_area_id = $request->input('org_area_id');
            $data->org_unidad_id = $request->input('org_unidad_id');
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

   public function export($mes) 
    {
        $data= Excel::download((new PresupuestoExport())->forMes($mes), 'presupuestoExport.xlsx');
        return $data;
        //return (new PresupuestoExport())->download('invoices.xlsx');
        //$contents = Excel::raw(new PresupuestoExport, 'users.xlsx');
       // return $contents;
        //return Excel::download(new PresupuestoExport(), 'users.xlsx');
    }
}