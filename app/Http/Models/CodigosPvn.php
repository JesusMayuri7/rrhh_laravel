<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class CodigosPvn extends Model {
    protected $primaryKey = 'idcodigo';
    //public $incrementing = false;
    public $timestamps = false; 
    protected $table = 'codigos_pvn';  
    
}