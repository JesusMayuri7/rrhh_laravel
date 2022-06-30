<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class VHomeCapEstadoOpp extends Model {
      
    
    protected $table = 'v_home_cap_estado_opp';  

    protected $casts = [
        'ocupado' => 'float',
        'vacante' => 'float',
        'reservado' => 'float',
    ];

}