<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class BonosController extends Controller
{
    public function index() {
        $data = DB::select('SELECT cod.tipo_remu_detalle,go.id idGrupo,go.desc_grupo,cod.abreviatura_comercial,cod.desc_comercial,cod.idcodigo,cod.codigo,cod.abreviatura,bo.monto
        FROM condicion con INNER JOIN grupo_ocupacional go ON con.id=go.condicion_id INNER JOIN bonos bo ON go.id=bo.grupo_ocupacional_id
        INNER JOIN codigos cod ON bo.idcodigo=cod.idcodigo ORDER BY abreviatura_comercial,desc_comercial,desc_grupo');
        return response()->json([
            "status" => true,
            "message" => 'Bonos',
            "data" =>$data
        ]);
    }
}