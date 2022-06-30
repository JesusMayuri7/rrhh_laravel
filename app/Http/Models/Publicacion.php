<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Publicacion extends Model {
    protected $primaryKey = 'id';
    //public $incrementing = false;
    protected $table = 'publicacion';  
    protected $fillable = [
        'convocatoria',
        'cargo',
        'modalidad',
        'tipo',
        'lugar_trabajo',
        'inscripcion',
        'cierre',
        'estado',
        'enlace'
    ];

    public function servicio_detalle() {
        return $this->belongsToMany('App\Http\Models\ServicioDetalle', 'certificacion_detalle_publicacion','publicacion_id','certificacion_detalle_id')
        ->withTimestamps()->withPivot('dni', 'nombres','estado');
    }

}