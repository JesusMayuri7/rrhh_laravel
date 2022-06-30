<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Direccion extends Model {
    protected $primaryKey = 'id';
    //public $incrementing = false;
    protected $table = 'org_direccion';     

    public function unidades(){
        return $this->hasMany('App\Http\Models\Unidad','org_direccion_id','id');
    }
}