<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Http\Models\PresupuestoDB;
use App\Http\Models\Clasificador;
use App\Http\Models\Direccion;
use App\Http\Models\Unidad;
use App\Http\Models\Area;
use App\Http\Models\Meta;
use App\Http\Models\Fuente;
use App\Http\Models\PresupuestoTotal;
use App\Http\Models\VCertificacionTotal;
use App\Http\Models\VPresupuestoCas;
use App\Http\Models\VPresupuestoCas2023;
use App\Http\Models\Pea;
use App\Exports\PresupuestoExport;
use App\Imports\PresupuestoImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;

class PresupuestoController extends BaseController
{

    public function resumen()
    {
        $data = PresupuestoTotal::get();  // revisar mes ? estaba con 6    
        return response()->json([
            "data" => $data,
        ]);
    }

    public function resumen2()
    {
        $data = db::select(db::raw("select * from v_presupuesto_total"));  // revisar mes ? estaba con 6    
        return response()->json([
            "data" => $data,
        ]);
    }

    public function presupuesto_cas($anio)
    {
        $data = VPresupuestoCas::where(['ano_eje'=>$anio])->get();  // revisar mes ? estaba con 6    
        return response()->json([
            "status" => true,
            "message"  => "Presupuesto CAS",
            "data" => $data,
        ]);
    }

 
    public function presupuesto_cas_ley()
    {
        $data = VPresupuestoCas2023::where(['ano_eje'=>'2023'])->get();    // revisar mes ? estaba con 6    
        return response()->json([
            "status" => true,
            "message"  => "Presupuesto CAS Ley",
            "data" => $data,
        ]);
    }

    public function presupuestoCap($anio)
    {
                $data = db::select(db::raw("select * from v_presupuesto_cap where ano_eje=:anio"),['anio'=>$anio]);  // revisar mes ? estaba con 6    
        return response()->json([
            "status" => true,
            "message"  => "Presupuesto CAP",
            "data" => $data,
        ]);
        
    }

    public function presupuestoCap2023()
    {
            $data = db::select(db::raw("select * from v_presupuesto_cap_2023"));  // revisar mes ? estaba con 6    
            return response()->json([
                "status" => true,
                "message"  => "Presupuesto CAP 2023",
                "data" => $data,
            ]);


    }

    public function getMetas($anio)
    {
        $metas = Meta::where(['anio'=> $anio])->get();        
        return response()->json([
            "status" => true,
            "data" => $metas,
            "message" => 'Listado de Metas'
        ]);
    }

    public function getFuentes()
    {
        $metas = Fuente::get();        
        return response()->json([
            "status" => true,
            "data" => $metas,
            "message" => 'Listado de Fuentes'
        ]);
    }

    public function getClasificadores($anio)
    {
        $data = Clasificador::where(['anio'=>$anio])->get();  // revisar mes ? estaba con 6    
        return response()->json([
            "status" => true,
            "message"  => "Clasificadores",
            "data" => $data,
        ]);
    }

    public function getClasificadoresCap()
    {
        $data = Clasificador::where(['modalidad_id'=>3])->get();  // revisar mes ? estaba con 6    
        return response()->json([
            "status" => true,
            "message"  => "Clasificadores",
            "data" => $data,
        ]);
    }

    public function variables(Request $request)
    {
        $data = db::select(db::raw("CALL sp_variables(:anio,:modalidadId,:dscVariable)"), ['anio' => $request->input('anio'),'modalidadId' => $request->input('modalidadId'),'dscVariable' => $request->input('dscVariable')]);  // revisar mes ? estaba con 6    
        return response()->json([
            "status" => true,
            "message"  => "listado de variables",
            "data" => $data,
        ]);
    }

    public function certificacion()
    {
        $data = VCertificacionTotal::where(['ano_eje'=>2023])->orderBy('certificado_id', 'desc')->get();  // revisar mes ? estaba con 6    
        return response()->json([
            "status" => true,
            "message"  => "listado de certificados",
            "data" => $data,
        ]);
    }

    public function certificacion_anio($anio)
    {
        $data = VCertificacionTotal::where(['ano_eje'=>$anio])->get();  // revisar mes ? estaba con 6    
        return response()->json([
            "status" => true,
            "message"  => "listado de certificados",
            "data" => $data,
        ]);
    }

    public function ejecucion()
    {
        $data = DB::select(DB::raw("SELECT * FROM v_ejecucion_total"));  // revisar mes ? estaba con 6    
        return response()->json([
            "data" => $data,
        ]);
    }

    public function metas($anio)
    {
        $metas2 = DB::select(DB::raw("SELECT * FROM v_metas2"));
        $metas = DB::select(DB::raw("SELECT * FROM v_metas WHERE anio=?",[$anio]));
        return response()->json([
            "status" => true,
            "metas" => $metas,
            "metas2" => $metas2
        ]);
    }

    public function dependencias() {
        //$metas = DB::select(DB::raw("SELECT * FROM v_metas"));
        //$metas2 = DB::select(DB::raw("SELECT * FROM v_metas2"));
        $organo =Direccion::where('org_funcional_id','>=',6)->get();
        $unidad = Unidad::get();
        $areas = Area::get();
        $areas2 = Area::where('id','>',60)->get();
        $unidad2 = Unidad::where('org_direccion_id','>=',11)->get();   
        return response()->json([
            "status" => true,
            "organos" =>$organo,
            "unidades" => $unidad,
            "areas" => $areas,
            "areas2" => $areas2,
            "unidades2" => $unidad2,
           // "metas" => $metas,
           // "metas2" => $metas2,
        ]);  
       }

       public function get_modalidad_concepto_clasificador() {
        $modalidad = DB::select(DB::raw("SELECT id,dsc_modalidad FROM modalidad where anio=2023"));
        $concepto = DB::select(DB::raw("SELECT id,dsc_concepto FROM concepto where anio=2023"));
        $clasificador = DB::select(DB::raw("SELECT id,dsc_clasificador FROM clasificador WHERE anio=2023"));
        return response()->json([
            "status" => true,
            "message"=> 'Modalidad y Conceptos',
            "data"=> ["modalidad"=>$modalidad,"concepto"=>$concepto, "clasificador"=>$clasificador]            
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
