<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class BaseCasDB extends Model {
    protected $primaryKey = 'id';
    //public $incrementing = false;
    protected $table = 'base_cas';  
    
    protected $fillable = [
       
        'detalle',
        'meta_id',  
        'cargo',
        'jerarquia',
        'monto',
        'sede',
        'modalidad',
        'meta_id2',
        'org_area_id',
        'estado_opp',
     
               
    ];
}