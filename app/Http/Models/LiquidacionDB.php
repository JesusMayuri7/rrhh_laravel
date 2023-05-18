<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class LiquidacionDB extends Model {
    protected $primaryKey = 'id';    
    public $incrementing = true;  
    protected $table = 'liquidacion';  

    protected $fillable = [
        'certificado_id',
        'meta_id',
        'fuente_id',
        'codigo_plaza',
        'dni',
        'nombres',
        'codigo_siga',
        'expediente',
        'fecha_expediente',
        'certificado_devengado_id',
        'fuente_devengado_id',
        'meta_devengado_id',
        'proceso',        
    ];

}