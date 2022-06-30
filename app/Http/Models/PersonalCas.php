<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalCas extends Model {
    //protected $primaryKey = 'id';
    public $incrementing = false;
    protected $table = 'siga_net_cas';    

    protected $fillable = [
    "id_unidejec",                    
    "id_personal",
    "nombres",                
    "nu_dociden",
    "nu_ruc",
    "id_contrato",
    "fe_contrato",
    "nu_contrato",                                        
    "fe_inicont",
    "fe_fincont",
    "mt_contmn",
    "id_servicio",
    "ds_servicio",
    "id_mnemonico",
    "id_cargo",
    "ds_cargo",
    "id_jerarquia",
    "ds_jerarquia",
    "id_prestamo",
    "fe_ingreso",
    "fe_cese",

    ];
}