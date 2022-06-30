<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class CertificacionDB extends Model {
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $table = 'certificacion';  
    
    protected $fillable = [
        "solicitud" ,
        "fecha_solicitud"
        ];
}