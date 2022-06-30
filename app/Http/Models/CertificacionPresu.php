<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class CertificacionPresu extends Model {
    //protected $primaryKey = 'id';
    public $incrementing = false;
    protected $table = 'certificacion_cas';    

    protected $fillable = [
        "ano_eje",
        "sec_ejec",
        "certificado",
        "secuencia",
        "correlativo",
        "rubro",
        "cod_doc",
        "num_doc",
        "fecha_doc",
        "ruc",
        "clasificador",
        "sec_func",
        "moneda",
        "tipo_cambio", 
        "monto",
        "monto_nacional",
        "fecha_autorizacion",
        "fecha_bd_oracle",
        "estado",
        "tipo_certificado",
        "tipo_registro",
        "estado_registro",
        "estado_envio"
    ];
}