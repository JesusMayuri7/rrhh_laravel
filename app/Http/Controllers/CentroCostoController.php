<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class CentroCostoController extends Controller
{
   public function index(){
    $data=\App\Http\Models\CentroCosto::get();
    return response()->json([
        "status" => true,
        "data" =>$data,
        "message"=>"Listados de origen",
        "log"=>"centros de costos"
    ],200); 

   }

}