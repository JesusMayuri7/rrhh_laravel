<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Models\RequerimientosDB;

class RequerimientosController extends Controller
{
   public function index(){
    $data=RequerimientosDB::get();
    return response()->json([
        "status" => true,
        "data" =>$data,
        "message"=>"Listados de origen",
        "log"=>"Requerimientos"
    ],200); 

   }

}