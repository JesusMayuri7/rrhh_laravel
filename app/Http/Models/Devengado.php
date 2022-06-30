<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Devengado extends Model {
    //protected $primaryKey = 'id';
    public $incrementing = false;
    protected $table = 'ejecucion_cas';    

    protected $fillable = [
        "ano_eje",        
        "certificado",
        "fuente_financ",
        "clasificador",
        "sec_func",
        "mes_proceso",
        "fase",
        "estado",
        "estado_envio",
        "num_doc",
        "fecha_doc",
        "ruc",
        "clasificador",        
        "moneda",
        "tipo_cambio", 
        "monto",
        "monto_nacional",
        "fecha_autorizacion",
        "fecha_bd_oracle"        
    ];
}