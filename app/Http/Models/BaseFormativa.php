<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class BaseFormativa extends Model {
    //protected $primaryKey = 'id';
    public $incrementing = false;
    protected $table = 'v_base_formativa';  
    




    protected $casts = [
     'monto_base' => 'float',
     'monto_siga' => 'float',
     'monto_air'=>'float',
     'sctr_pension' =>'float',     
     'subvencion' =>'float',     
    ];
}