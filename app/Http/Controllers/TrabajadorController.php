<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Route;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;
use App\Http\Requests\ValidViaticoRequest;
use Validator;

class TrabajadorController extends Controller
{

   public function index(){
       return \App\Http\Models\Trabajador::orderBy('idtrabajador', 'desc')->get();       
   }     

   public function getNombres(Request $request){
       try {
                $trabajador =\App\Http\Models\Trabajador::where('dni', $request->input('dni'))->firstOrFail();
                return response()->json([
                "status" => true,
                "data" =>$trabajador,
                "message"=> "registro recibido",
                "log"=> "registro de la base de datos"
                ],200);        
            } 
            catch (ModelNotFoundException $e) {            
                    return response()->json([
                        "status" => false,
                        "message" => "Personal no registrado",
                        "data" => '',
                        "log" => "Personal no existe en la base de datos"
                    ],201);      
            }                        
   }
            
    public function postdni(Request $request)
    {              
       try {
        $trabajador =\App\Http\Models\Trabajador::where('dni', $request->input('dni'))->firstOrFail();
                return response()->json([
                "status" => true,
                "data" =>$trabajador,
                "message"=> "registro recibido",
                "log"=> "registro de la base de datos"
                ],200);        
        } catch (ModelNotFoundException $e) {
            try {                        
                //$result = json_decode($response->getBody());
                $nuevoTrabajador = new \App\Http\Models\Trabajador;
                $nuevoTrabajador->dni =$request->input('dni');
                $nuevoTrabajador->nombres = $request->input('nombres');      
                $nuevoTrabajador->save();
                if ($nuevoTrabajador) {
                    return response()->json([
                        "status" => false,
                        "message" => "Registro agregado con exito",
                        "data" => $nuevoTrabajador,
                        "log" => "nuevo ingreso de trabajador"
                    ],201);      
                }
             
            }
            catch (RequestException $e) {
                $exception=null;
                if ($e->hasResponse()) {
                    $exception = (string) $e->getResponse()->getBody();
                    $exception = json_decode($exception);
                }  
                return response()->json([
                    "status" => false,
                    "message" => "error de conexion, intentelo mas tarde.",
                    "data" => null,                   
                    "log" => $exception,                    
                ],503);
            }           
        }
    }
 
}