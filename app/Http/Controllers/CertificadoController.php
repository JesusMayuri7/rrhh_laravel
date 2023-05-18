<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
 use App\Http\Models\Certificado;
 use App\Http\Models\VCertificadoCas;
 use App\Http\Models\VCertificadoPracticante;
 use App\Http\Models\certificadoCap;
 use App\Http\Models\CertiClasiModaConcepto;

use Illuminate\Http\Request;

class CertificadoController extends BaseController
{
    public function index(Request $request) {        
        $data=null;
        try
        {
            $data = Certificado::where("dsc_certificado",str_pad($request->input('dsc_certificado'), 10, "0", STR_PAD_LEFT))->where("anio",$request->input("anio"))
            ->orderBy('dsc_certificado','ASC')->
            first();            
            $status = true;   
            return response()->json([
                "status" => $status,
                "message" => 'Certificado',
                "data" =>$data
            ]);           
        }
        catch (Exception $e){
            return response()->json([
                "status" => $false,
                "message" => 'Certificado',
                "data" =>$data
            ]);
        }        
    }

    public function certificadoCas($anio) {        
        $data=null;
        $status=false;
        try
        {
            $data = VCertificadoCas::where("ano_eje",$anio)->get();            
            $status = true;              
        }
        catch (Exception $e){
            $status=false;
        }
        
        return response()->json([
            "status" => $status,
            "message" => 'Certificado CAS',
            "data" =>$data
        ]);
    }

    public function certificadoPracticante($anio) {        
        $data=null;
        $status=false;
        try
        {
            $data = VCertificadoPracticante::where("ano_eje",$anio)->get();            
            $status = true;              
        }
        catch (Exception $e){
            $status=false;
        }
        
        return response()->json([
            "status" => $status,
            "message" => 'Certificado PRAC',
            "data" =>$data
        ]);
    }

    public function certificadoCap($anio) {        
        $data=null;
        $status=false;
        try
        {
            $data = CertificadoCap::where("ano_eje",$anio)->get();            
            $status = true;              
        }
        catch (Exception $e){
            $status=false;
        }
        
        return response()->json([
            "status" => $status,
            "message" => 'Certificado CAP',
            "data" =>$data
        ]);
    }

    public function certificados($anio) {        
        $data=null;
        try
        {
            $data = Certificado::where("anio",$anio)->orderBy('dsc_certificado','ASC')->get();            
            $status = true;              
        }
        catch (Exception $e){
            $status=false;
        }
        
        return response()->json([
            "status" => $status,
            "message" => 'Certificado',
            "data" =>$data
        ]);
    }

    public function save(Request $request) {
        $status =1;
        $result = [];

        try {
            $result=DB::transaction(function () use ($request) {               
                    $certificado = new Certificado();
                    $certificado->detalle = $request->input("detalle");
                    $certificado->tipo = $request->input("tipo");
                    $certificado->dsc_certificado = str_pad($request->input('dsc_certificado'), 10, "0", STR_PAD_LEFT);   
                    $certificado->monto = $request->input('monto');            
                    $certificado->anio = $request->input('anio');    
                    $certificado->save();                      
                    $campos = $request->input("clasificador_concepto");                            
                    foreach($campos as $a){
                        $item = new CertiClasiModaConcepto();
                        $item->certificado_id = $certificado->id;
                        $item->clasificador_id = $a["clasificador_id"];
                        $item->modalidad_id =  $request->input('modalidad_id');
                        $item->concepto_id = $a["concepto_id"];            
                        $item->save();
                        }                
                //$bien = Publicacion::insert($publi);
               return $certificado;
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
}