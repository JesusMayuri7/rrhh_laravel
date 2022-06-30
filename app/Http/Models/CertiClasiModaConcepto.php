<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class CertiClasiModaConcepto extends Model {
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $table = 'certi_clasi_moda_concepto';     
    
    protected $fillable =[
        "certificado_id",
        "clasificador_id",
        "modalidad_id",
        "concepto_id",
    ];
    
}