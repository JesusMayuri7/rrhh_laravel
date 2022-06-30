<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class LiquidacionCas extends Model {
    protected $primaryKey = 'id';    
    protected $table = 'v_liquidacion_cas';  

    protected $casts = [
        'anio' => 'string',        
       ];
}