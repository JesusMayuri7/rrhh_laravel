<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class AirHspCodigosDB extends Model {
    protected $primaryKey = 'id';
    //public $incrementing = false;
    public $timestamps = false; 
    protected $table = 'activos_air_codigos';  
    
}