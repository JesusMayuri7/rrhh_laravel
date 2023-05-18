<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class AirHsp extends Model {
    //protected $primaryKey = 'idpap';
    public $incrementing = false;
    protected $table = 'v_airhsp_cap';  
    
    protected $casts = [
        'RemPrinRO' => 'float',
        'RemPrinRDR' => 'float',
        'BonFam'=>'float',
        'Incremento'=>'float',
        'Essalud' =>'float',     
        'mensual' =>'float',    
        'monto_air' =>'float',    
        'monto_air_page' =>'float',    
        'BonifEsco' =>'float',    
        'BoniPatrias' =>'float',    
        'BoniNavidad' =>'float',    
        'BoniExtJulio' =>'float',    
        'BoniExtDic' =>'float',    
        'total' =>'float',    


       ];
}