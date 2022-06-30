<?php

namespace App\Http\Controllers;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;


use Excel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Http\Request;
use Illuminate\Http\File;
use App\Http\Models\VHomeDevengadoTotal;
use App\Http\Models\VHomeCapEstadoOpp;
use Illuminate\Support\Facades\Storage;

class HomeController extends BaseController
{
   public function devengadoTotal() {
    $homeData = VHomeDevengadoTotal::get();
    
        return response()->json([
            "status" => true,
            "message" => 'Listado de Liquidaciones',
            "data" =>$homeData
        ]);       
   }

   public function capEstadoOpp() {
    $homeData = VHomeCapEstadoOpp::get();
    
        return response()->json([
            "status" => true,
            "message" => 'Listado de Liquidaciones',
            "data" =>$homeData
        ]);       
   }
}