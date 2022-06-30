<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class PlanillaCapCodigos extends Model {
  //  protected $primaryKey = 'id';
    //public $incrementing = false;
    protected $table = 'planilla_cap_codigos';  
 
    protected $fillable = [          
      "id_personal",               
      "codigo",  
      "monto",
      "id_codigo"
    ];

}