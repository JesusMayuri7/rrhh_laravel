<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model {
    protected $primaryKey = 'id';
    //public $incrementing = false;
    protected $table = 'org_area';  

    public function servicios(){
        return $this->hasMany('App\Http\Models\Servicios','org_area_id','id');
    }
}