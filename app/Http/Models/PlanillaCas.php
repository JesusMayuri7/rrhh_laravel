<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class PlanillaCas extends Model {
  //  protected $primaryKey = 'id';
    //public $incrementing = false;
    protected $table = 'planilla_cas';  
 
    protected $fillable = [
    "id_personal",               
    "dni",
    "nombres",
    "monto",
    "aguinaldo",
    "reintegro",
    "incremento",
    "bono",
    "total_ingreso",
    "retencion_cuarta",
    "otros_si_afecto",
    "otros_no_afecto",
    "afp_base",
    "afp_comision",
    "afp_prima",
    "essalud",
    "sctr_pension",
    "sctr_salud",
    "total_aporte",
    "total_descuento",
    "total_neto",
    "meta",
    "fuente",
    "mes",
    "anio",
    "descripcion",
    "dscto_no_remunerativo_01",
    "dscto_no_remunerativo_02"
    ];

}