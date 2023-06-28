<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use App\Http\Models\CodigosAirhsp;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Tymon\JWTAuth\Facades\JWTAuth;

class CodigoAirhspController extends BaseController
{

    public function index()
    {
        $data = CodigosAirhsp::where(['anio'=> 2023, 'modalidad_id' => 8])->get();  
        // $data = DB::select('CALL presupuesto(?)', array('2018'));
        //$data = collect(DB::select(DB::raw("CALL sp_reporte_excel_air(:anio,:modalidad_id)"), ['anio' => 2023,'modalidad_id' => 8]));  // revisar mes ? estaba con 6
        $pea = CodigosAirhsp::get();
        return response()->json([
            "data" => $data,
            'status'  => true,
            'message'  => 'air'
        ]);
    } 

}
