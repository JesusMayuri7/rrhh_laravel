<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class BaseFormativaDB extends Model {
    protected $primaryKey = 'id';
    //public $incrementing = false;
    protected $table = 'base_practicante';  
    
    protected $fillable = [
        'dni',
        'nombres', 
        'org_unidad_id',
        'sede',
        'meta_id',
        'cargo',
        'estado',
        'presupuesto',
        'monto',
        'detalle',
        'tipo',
        'tramite',
        'nro_tramite',
        'dependencia',
        'tipo2',
        'org_area_id',
        'estado_opp' ,
        'estado_pap'  ,
        'fecha_alta',
        'fecha_baja'
    ];
}