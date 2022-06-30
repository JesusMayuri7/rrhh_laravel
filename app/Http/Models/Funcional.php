<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Funcional extends Model {
    protected $primaryKey = 'id';
    //public $incrementing = false;
    protected $table = 'org_funcional';   
    
    public function direcciones(){
        return $this->hasMany('App\Http\Models\Direccion','org_funcional_id','id');
    }

}