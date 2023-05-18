<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Documentos extends Model {
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $table = 'documentos';  
    protected $fillable= [
        "expediente_pvn", 
        "numero_pvn" , 
        "remite" , 
        "fecha" ,
        "estado" ,
        "fecha_derivacion" ,
        "asunto" , 
        "anio" ,        
        "tipo",
        "control"
    ];

}
