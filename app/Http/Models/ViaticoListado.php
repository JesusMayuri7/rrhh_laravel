<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Models;

class ViaticoListado extends Model {
    protected $table = 'viatico_listado';
    protected $primaryKey = 'id';
    protected $fillable = [
        'informe',
        'sustento',
        'anio',
        'inicio',
        'fin',
        'descripcion',
        'idviatico_trabajador',
        'estado'
    ];

    public function viaticoNumeracion(){
      return $this->hasMany('App\Http\Models\ViaticoNumeracion','viatico_id','id');
      }

    public function centroCosto(){
		return $this->belongsTo('App\Http\Models\CentroCosto','idcentro_costo','id');
    }

}