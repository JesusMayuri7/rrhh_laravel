<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class VCertificadoCas extends Model {
    protected $table = 'v_certificacion_cas'; 
    
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