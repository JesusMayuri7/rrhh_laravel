<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class PlanillaFormativa extends Model {
  //  protected $primaryKey = 'id';
    //public $incrementing = false;
    protected $table = 'planilla_formativa';  
 
    protected $fillable = [
    "id_personal",               
    "dni",
    "nombres",
    "monto",
    "media",
    "reintegro",
    "total_ingreso",    
    "sctr_pension",
    "sctr_salud",
    "total_aporte",    
    "meta",
    "fuente",
    "mes",
    "anio",
    "descripcion",
    "descuento"
    ];

}