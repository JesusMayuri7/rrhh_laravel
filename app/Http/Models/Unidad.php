<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model {
    protected $primaryKey = 'id';
    //public $incrementing = false;
    protected $table = 'org_unidad';   

    /*
    public function areas(){
        return $this->hasMany('App\Http\Models\Area','org_unidad_id','id');
    }
    */
}