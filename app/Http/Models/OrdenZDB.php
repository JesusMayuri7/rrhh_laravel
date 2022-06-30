<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenZDB extends Model {
    //protected $primaryKey = 'id';
    public $incrementing = false;
    protected $table = 'ordenesz';   
    public $timestamps = false; 

    protected $fillable = [
        'nro_orden',
        'nemonico',
        'meta',
        'ejecutora_sede',
        'tipo',
        'denominacion',
        'plazo_dias',
        'responsable',
        'ruc',
        'proveedor',
        'monto',
        'fecha',
        'fecha_inicio',
        'fecha_fin'
    ];
  



}