<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class PlanillaCap extends Model {
  //  protected $primaryKey = 'id';
    //public $incrementing = false;
    protected $table = 'planilla_cap';  
 
    protected $fillable = [
      
      
      "cod_trabajador",               
      "COD_PERIODO",
      "txt_nombres",      
      "cod_plaza",
      "txt_cargo",            
      "COD_ZONAL",
      "COD_TIPZON",
      "COD_ZONUND",
      "COD_JERARQUIA",
      "COD_AREDIR",
      "COD_AREGER",
      "flg_sist_pens",
      "txt_sist_pens",
    "num_dias_base",
    "fec_ini_vacsub",
    "fec_fin_vacsub",
    "cod_mnemonico",
    /*
    "remuneracion",
    "r_remuneracion",
    "asig_familiar",
    "r_a_familiar",
    "vacaciones",
    "r_vacaciones",
    "onp_19990",
    "afp_base",
    "afp_prima",
    "afp_comision",
    "essalud",
    "eps",
    "gratificacion",
    "r_gratificacion",
    "quinta_categoria",
    "dscto_judicial",
    "essalud_vida",
    "vida_ley",
    "cts",
    "r_cts",    
    "sctr_pension",
    "faltas",
    "tardanzas",
    "permisos_dias",
    "permisos_min",
    "sctr_salud",
    "prestamo_cafae",
    "seguro_medico_familiar",
    "sutraproviasnac",
    "otros_dsctos",*/
    "tot_aportes",
    "tot_descuentos",
    "tot_ingresos",    
    "fuente",
    "meta",
    "mes",
    "anio",
    "descripcion"
    ];

    public function planilla_codigos(){
      return $this->hasMany('App\Http\Models\PlanillaCapCodigos','planilla_id','id');
  }


}