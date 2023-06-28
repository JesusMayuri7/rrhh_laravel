<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class SolicitudDetalle extends Model {
    protected $primaryKey = 'id';
    //public $incrementing = false;
    protected $table = 'certificacion_detalle';   
    public $timestamps = false; 

    protected $fillable = [
        'cargo',
        'dependencia',     
        'codigo_plaza',
        'meses',
        'monto',
        'modalidad' ,
        'area_id',
        'anio',
        'modalidad_concurso',
        'sustento_legal',
        'anulado',
        'meta_id'
    ];
  
    public function solicitud(){           
	  return $this->belongsTo('App\Http\Models\Solicitud','certificacion_id','id');	
    }

    public function publicacion() {
        return $this->belongsToMany('App\Http\Models\Publicacion', 'certificacion_detalle_publicacion','certificacion_detalle_id','publicacion_id')
        ->withTimestamps()->withPivot('dni', 'nombres','estado');
    }
}