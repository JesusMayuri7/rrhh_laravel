<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class VCertificacionTotal extends Model {
    protected $table = 'v_certificacion_total'; 
    
    protected $casts = [        
        'monto'=> 'float',
        'saldo' => 'float',
        'enero'=> 'float',
        'febrero'=> 'float',
        'marzo'=> 'float',
        'abril'=> 'float',
        'mayo'=> 'float',
        'junio' => 'float',
        'julio'=> 'float',
        'agosto'=> 'float',
        'setiembre'=> 'float',
        'octubre'=> 'float',
        'noviembre'=> 'float',
        'diciembre'=> 'float',
        'devengado'=> 'float',
        
    ];


}