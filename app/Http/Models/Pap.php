<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Pap extends Model {
    protected $primaryKey = 'idpap';
    //public $incrementing = false;
    protected $table = 'pap';  
    protected $fillable = [
        'detalle',
        'idmeta',
        'cargo',
        'jerarquia',
        'monto',  
        'situacion2',
        'idmeta2',
        'org_unidad_id',
        'org_area_id',
        'tipo_ingreso',    
        'estado_opp',
        'cargo_pap',
        'eps_aporte',
        'cargo_judicial',
        "monto_judicial"
    ];
    
}