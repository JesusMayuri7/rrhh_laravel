<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Http\Models\PresupuestoDB;
use App\Http\Models\Direccion;
use App\Http\Models\Unidad;
use App\Http\Models\Pea;
use App\Exports\PresupuestoExport;
use App\Imports\PresupuestoImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;

class ConfiguracionController extends BaseController
{



    public function laudos()
    {
        $data = db::select(db::raw("select * from v_escala"));  // revisar mes ? estaba con 6    
        return response()->json([
            "data" => $data,
        ]);
    }

    public function certificados()
    {
        $data = db::select(db::raw("select * from v_certificado_resumen"));  // revisar mes ? estaba con 6    
        return response()->json([
            "data" => $data,
        ]);
    }

    public function mop()
    {
        $data = db::select(db::raw("select * from v_mop"));  // revisar mes ? estaba con 6    
        return response()->json([
            "data" => $data,
        ]);
    }

    public function convocatorias()
    {
        $data = db::select(db::raw("select * from v_publicacion"));  // revisar mes ? estaba con 6    
        return response()->json([
            "data" => $data,
        ]);
    }

    public function certificacion()
    {
        $data = db::select(db::raw("select * from v_certificacion_total"));  // revisar mes ? estaba con 6    
        return response()->json([
            "data" => $data,
        ]);
    }

    public function tipo_requerimientos()
    {
        $data = db::select(db::raw("select * from tipo_requerimiento"));  // revisar mes ? estaba con 6    
        return response()->json([
            "data" => $data,
            "status" => true,
            "message" => "Listado de Tipo de Requerimientos"
        ]);
    }

    public function ejecucion()
    {
        $data = DB::select(DB::raw("SELECT * FROM v_ejecucion_total"));  // revisar mes ? estaba con 6    
        return response()->json([
            "data" => $data,
        ]);
    }

    public function metas()
    {
        $metas = DB::select(DB::raw("SELECT * FROM v_metas"));
        $metas2 = DB::select(DB::raw("SELECT * FROM v_metas2"));
        return response()->json([
            "status" => true,
            "metas" => $metas,
            "metas2" => $metas2
        ]);
    }

    public function dependencias() {
        $metas = DB::select(DB::raw("SELECT * FROM v_metas"));
        $metas2 = DB::select(DB::raw("SELECT * FROM v_metas2"));
        $organo =Direccion::where('org_funcional_id','>=',6)->get();
        $unidad = Unidad::get();
        $unidad2 = Unidad::where('org_direccion_id','>=',11)->get();   
        return response()->json([
            "status" => true,
            "organos" =>$organo,
            "unidades" => $unidad,
            "unidades2" => $unidad2,
            "metas" => $metas,
            "metas2" => $metas2
        ]);  
       }

       public function areas() {
        $data = db::select(db::raw("select org_area_id as id,desc_area from v_mop "));  
        return response()->json([
            "status" => true,
            "message" => "Areas",
            "data" => $data,
        ]); 
       }

       public function modalidades($anio) {
        $data = db::select(db::raw("select id,dsc_modalidad from modalidad where anio= :anio"),['anio' => $anio]);  // revisar mes ? estaba con 6    
        return response()->json([
            "status" => true,
            "message" => "Modalidades",
            "data" => $data,
        ]);
        }

    public function index($mes)
    {
        // $data = DB::select('CALL presupuesto(?)', array('2018'));
        $data = collect(DB::select(DB::raw("CALL sp_proyeccion_presupuestal_cap(:mes)"), ['mes' => $mes]));  // revisar mes ? estaba con 6
        $pea = Pea::get();
        return response()->json([


            "data" => $data,
            'peas'  => $pea
        ]);
    }

    public function export($mes)
    {
        $data = Excel::download((new PresupuestoExport())->forMes($mes), 'presupuestoExport.xlsx');
        return $data;
        //return (new PresupuestoExport())->download('invoices.xlsx');
        //$contents = Excel::raw(new PresupuestoExport, 'users.xlsx');
        // return $contents;
        //return Excel::download(new PresupuestoExport(), 'users.xlsx');
    }


    public function import(Request $request)
    {
        $destinationPath = 'uploads';
        $file = $request->file('file');

        /* if(!Storage::disk('local')->put($file->getClientOriginalName(), $file)) {
            return false;
        }*/
        $file->move(storage_path('app'), $file->getClientOriginalName());
        if (Storage::disk('local')->exists($file->getClientOriginalName())) {
            //\App\Http\Models\PresupuestoDB::where('ano_eje',)->delete();
            Excel::import(new PresupuestoImport, $file->getClientOriginalName(), 'local', \Maatwebsite\Excel\Excel::XLS);
            return response()->json([
                "status" => true,
                "data" => PresupuestoDB::count()
            ]);
        }



        //(new OrdenImport)->import('ordenes.XLS', 'local', \Maatwebsite\Excel\Excel::XLSX);       
        // return redirect('/')->with('success', 'All good!');
    }
    //


}
