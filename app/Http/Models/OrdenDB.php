<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class OrdenDB extends Model {
    protected $primaryKey = 'id';
    //public $incrementing = false;
    protected $table = 'ordenes';   
    public $timestamps = false; 

    protected $fillable = [
        'caso',
        'centro_costo',    
        'nombre_depend',
        'nro_orden',
        'fecha_orden',
        'opcion',
        'nro_pedido',
        'nro_requer',
        'tipo_pedido',
        'exp_siaf',
        'nro_ruc',
        'nombre_prov',
        'valor',
        'wtipo_proceso',
        'dsc_orden',
        'tipo_bien',
        'sec_cuadro', 
    ];
  



}