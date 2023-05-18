<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class JudicialesV extends Model {
    //protected $primaryKey = 'idpap';    
    protected $table = 'v_judiciales';  
    
    protected $casts = [
        'monto_judicial' => 'float',        
        'monto_planilla' => 'float',        
       ];
}