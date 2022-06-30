<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class VHomeDevengadoTotal extends Model {
      
    
    protected $table = 'v_home_devengado_total';  

    protected $casts = [
        'monto' => 'float',
        'total' => 'float',

       ];

}