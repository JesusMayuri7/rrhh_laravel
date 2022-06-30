<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class LiquidacionDetalleDB extends Model {
    protected $primaryKey = 'id';  
    public $incrementing = true;  
    protected $table = 'liquidacion_detalle';  

    protected $fillable = [
        'monto_certificado',
         'monto_liquidacion', 
        'monto_devengado',        
        'monto_devolucion'
    ];

    protected $casts = [
     'monto_certificado' => 'float',
     'monto_liquidacion'=>'float',
     'monto_devengado' =>'float',
     'monto_devolucion' =>'float'
    ];
}