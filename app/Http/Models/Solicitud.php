<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Solicitud extends Model {
    protected $primaryKey = 'id';
    //public $incrementing = false;
    protected $table = 'certificacion';   
    public $timestamps = true; 

    protected $fillable = [
        'expediente',
        'solicitud',          
        'respuesta',
        'tipo',
        'motivo',
        'fecha_solicitud'
    ];
  
    public function solicitudDetalle(){           
        return $this->hasMany('App\Http\Models\SolicitudDetalle','certificacion_id',"id");	
      }


}