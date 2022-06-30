<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Servicios extends Model {
    protected $primaryKey = 'id';
    //public $incrementing = false;
    protected $table = 'v_servicios';  

    public function servicios_detalle(){
        return $this->hasMany('App\Http\Models\ServiciosDetalle','servicios_id','id');
    }

}