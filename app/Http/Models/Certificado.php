<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Certificado extends Model {
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $table = 'certificado';  
    
    protected $fillable = [
        "dsc_certificado" ,
        "detalle",
        "monto",
        "anio",
        'tipo'
        ];

        protected $hidden = ['updated_at', 'created_at'];
}