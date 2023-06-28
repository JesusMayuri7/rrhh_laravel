<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class BaseCasDetalle extends Model {
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $table = 'base_cas_detalle';  
    
    protected $fillable = [
        "nombres" ,
        "detalle",
        "cargo",
        "tipo_ingreso",
        "fe_ingreso",
        "fe_salida",
        "fin_licencia",
        "tipo_salida",
        "doc_salida",
        "doc_ingreso",
        "doc_licencia",
        "teletrabajo"
    ];
}