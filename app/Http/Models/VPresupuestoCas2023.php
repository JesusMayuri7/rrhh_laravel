<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class VPresupuestoCas2023 extends Model {
    protected $table = 'v_presupuesto_cas_ley'; 
    
    protected $casts = [        
        "pia"=>"float",
        "pim"=>"float",
        "certificado"=>"float",
        "devengado"=>"float",
        "enero"=>"float",
        "febrero"=>"float",
        "marzo"=>"float",
        "abril"=>"float",
        "mayo"=>"float",
        "junio"=>"float",
        "julio"=>"float",
        "agosto"=>"float",
        "setiembre"=>"float",
        "octubre"=>"float",
        "noviembre"=>"float",
        "diciembre"=>"float",
        
    ];


}