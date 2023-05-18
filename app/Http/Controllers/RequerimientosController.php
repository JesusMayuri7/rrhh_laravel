<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;
use App\Http\Models\RequerimientosDB;
use Illuminate\Support\Facades\DB;

class RequerimientosController extends BaseController
{
   public function index($anio){ 
    $data=RequerimientosDB::where(['anio'=>$anio])->get();
    return response()->json([
        "status" => true,
        "data" =>$data,
        "message"=>"Listados de origen",
        "log"=>"Requerimientos"
    ],200); 

   }

}