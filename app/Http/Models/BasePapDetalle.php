<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class BasePapDetalle extends Model {
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $table = 'pap_detalle';  
    
    protected $fillable = [
        'pap_id',
        'codigo_plaza',
        'plaza',
        'fuente_id',
        'meta_id',
        'monto',
        'dependencia_id',
        'monto_siga',
        'dni',
        'nombres',
        'id_personal',
        'tipo_ingreso',
        'tipo_salida',
        'fe_ingreso',
        'detalle',  
        'org_unidad_id',
        'fe_salida',
        'fin_licencia',
        'doc_ingreso',
        'doc_salida',
        'doc_licencia'
    ];
}