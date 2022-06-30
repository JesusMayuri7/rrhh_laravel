<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class BaseServicios extends Model {
    protected $primaryKey = 'id';
    //public $incrementing = false;
    protected $table = 'base_servicios';   
    public $timestamps = false; 

    protected $fillable = [
        'control',
        'tiempo_servicio',          
    ];
  



}