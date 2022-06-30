<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class PresupuestoTotal extends Model {
    protected $table = 'v_presupuesto_total'; 
    
    protected $casts = [
        'pia'=> 'float',        
        'pim'=> 'float',
        'certificado'=> 'float',
        'saldo'=> 'float',
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