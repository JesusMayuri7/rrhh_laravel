<?php

namespace App\Http\Controllers;
use App\Imports\OrdenImport;
use App\Imports\OrdenZImport;
use App\Exports\OrdenesSigaMefExport;
use App\Http\Models\OrdenDB;
use App\Http\Models\OrdenZDB;
use Illuminate\Support\Facades\DB;
use App\Http\Models\BaseServicios;
use App\Http\Models\SigaZ;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class OrdenController extends Controller 
{
    public function listarz(Request $request){

        $where = function ($query) use ($request) {
            if ($request->input('parametro')=='nro_orden') {
                    $query->where('nro_orden',$request->input('valor'));
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
            if ($request->input('parametro')=='ruc') {
                    $query->where('ruc',$request->input('valor'));
                }
            if ($request->input('estado')) {
                if ($request->input('estado')!='TODOS') {
                        $query->whereRaw("estados = CONVERT(? USING utf8)", [$request->input('estado')]);
                    }
                }
            if ($request->input('zonales')) {
                if ($request->input('zonales')!='TODOS') {
                        $query->where('ejecutora_id',$request->input('zonales'));
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
          //  dd($query);
        };        
       // $data = SigaZ::get();
        $data = SigaZ::where($where)->orderBy('orden', 'desc')->
        paginate(100, ['*'], 'page', 0);
       // $zonales = Area::get();
        return response()->json([
            "status" => $request->input('estado'),
            "data" => $data,
         //   'zonales' => $zonales
        ]); 
    }

    public function ordenes_pendientes_tiempo(Request $request) {
        $data =DB::select(DB::raw("CALL sp_ordenes_pendientes_tiempo(?)"),['2020']);
        //$data =DB::select(DB::raw("CALL sp_matriz_control(?)"),[$request->input('idpap')]);
        return response()->json([
            "status" => true,
            "data" =>$data
        ]);       
       }

    public function actualizar_tiempo(Request $request){           
        try {
        $result=DB::transaction(function () use ($request) {
            if ($request->input('id')) {   
                $data = BaseServicios::where(['id'=>$request->input('id'),'lugar'=>'SEDE',
                'anio'=>$request->input('anio')])->update(['tiempo_servicio'=>$request->input('tiempo')]);
            } 
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

       public function actualizar_control(Request $request){           
        try {
        $result=DB::transaction(function () use ($request) {
            if ($request->input('orden') && $request->input('base_servicios_id')) {   
                $data = BaseServicios::where(['nro_orden'=>$request->input('orden'),'id'=>$request->input('base_servicios_id'),'lugar'=>'SEDE','anio'=>'2020'])
                ->update(['control'=>$request->input('control'),'tiempo_servicio'=>$request->input('plazos') ?? 0,'condicion'=>$request->input('condicion')]);
                return $data;
            }
            throw ('data sin especificar');
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

       public function actualizar_control_z(Request $request){           
        try {
        $result=DB::transaction(function () use ($request) {
            if ($request->input('orden') && $request->input('base_servicios_id')) {   
                $data = BaseServicios::where(['nro_orden'=>$request->input('orden'),'id'=>$request->input('base_servicios_id'),'lugar'=>'ZONAL'])
                ->update(['control'=>$request->input('control'),'tiempo_servicio'=>$request->input('plazos') ?? 0,'condicion'=>$request->input('condicion')]);
                return $data;
            }
            throw ('data sin especificar');
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



    public function import(Request $request) 
    {
        
        $destinationPath = 'uploads';
        $file = $request->file('file');

       /* if(!Storage::disk('local')->put($file->getClientOriginalName(), $file)) {
            return false;
        }*/
        $file->move(storage_path('app'),$file->getClientOriginalName());
        if (Storage::disk('local')->exists($file->getClientOriginalName())) 
        {
            \App\Http\Models\OrdenDB::where('anio',2020)->delete();
            Excel::import(new OrdenImport, $file->getClientOriginalName(), 'local', \Maatwebsite\Excel\Excel::XLS);
            return response()->json([
                "status" => true,
                "data" => OrdenDB::count()
            ]); 
        }
    }

    public function importZ(Request $request) 
    {
        
        $destinationPath = 'uploads';
        $file = $request->file('file');
       
        $file->move(storage_path('app'),$file->getClientOriginalName());
        if (Storage::disk('local')->exists($file->getClientOriginalName())) 
        {
            \App\Http\Models\OrdenZDB::query()->delete();
         Excel::import(new OrdenZImport, $file->getClientOriginalName(), 'local', \Maatwebsite\Excel\Excel::XLS);
         //Excel::import(new OrdenZImport, 'ReporteOrdenPorMeta.xls', 'local', \Maatwebsite\Excel\Excel::XLS);
            return response()->json([
                "status" => true,
                "data" => OrdenZDB::count()
            ]); 
        }
    }

    public function export() 
    {
        $data= Excel::download((new OrdenesSigaMefExport()), 'OrdenesSigaMef.xlsx');
        return $data;
        //return (new PresupuestoExport())->download('invoices.xlsx');
        //$contents = Excel::raw(new PresupuestoExport, 'users.xlsx');
       // return $contents;
        //return Excel::download(new PresupuestoExport(), 'users.xlsx');
    }
}