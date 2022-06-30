<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class NivelController extends Controller
{
    public function index(){
        $data = DB::select('SELECT nivel.idnivel,descripcion,desc_nivel,                
        SUM(0) AS remuneracion FROM nivel 
        LEFT JOIN profesion ON nivel.idprofesion=profesion.idprofesion         
        #LEFT JOIN codigos_pvn c ON c.tipo=1 AND nivel_codigo.idcodigo=c.idcodigo
        WHERE nivel.anio=2019 GROUP BY nivel.idnivel ORDER BY idnivel');
        return response()->json([
            "status" => true,
            "message" => 'Nivel',
            "data" =>$data
        ]);
    }
}