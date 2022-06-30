<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Models;

class ViaticoCab extends Model {
    protected $table = 'viaticos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'informe',
        'sustento',
        'anio',
        'inicio',
        'fin',
        'idcentro_costo'
    ];

    
    public function viaticoDet(){
		return $this->hasMany('App\Http\Models\ViaticoDet','viatico_id','id');
    }
    public function viaticoNumeracion(){
      return $this->hasMany('App\Http\Models\ViaticoNumeracion','viatico_id','id');
      }

    public function centroCosto(){
		return $this->belongsTo('App\Http\Models\CentroCosto','idcentro_costo','id');
    }

}