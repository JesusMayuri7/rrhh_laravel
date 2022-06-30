<?php

namespace App\Http\Controllers;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TodoController extends Controller
{
   public function index(){
       return \App\Http\Models\Todo::orderBy('fecha','DESC')->orderBy('nivel', 'ASC')->get();       
   }

   public function save(Request $request){

     $new = new  \App\Http\Models\Todo;
     $new->nivel = $request->input('nivel');
     $new->titulo = $request->input('titulo');
     $new->texto = $request->input('texto');
     $new->fecha = $request->input('fecha');
     $new->tipo = $request->input('tipo');
     $new->save();

     return response()->json([
        "label" => 1,
        "data" =>$request->input()
    ]);
    }

    public function delete(Request $request,$id){
        try {
        $todo = \App\Http\Models\Todo::findOrFail($id);
        if($todo->delete()) {
            return response()->json([
            "status" => true,
            "data" =>$todo
            ]);
        }        
        } catch (ModelNotFoundException $e) {
            return response()->json([
                "status" => false,
                "data" =>$e
                ]);
        }
    }
 
}