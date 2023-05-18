<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class RequerimientosDB extends Model {
    //protected $primaryKey = 'idpap';
    public $incrementing = false;
    protected $table = 'v_requerimientos';  
    protected $casts = [        
        "cantidad"=>"float"
        
    ];
    
}