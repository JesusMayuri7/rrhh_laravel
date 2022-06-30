<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class LiquidacionReport extends Model {       
    protected $table = 'v_liquidacion_rpt';  

    protected $casts = [
        'total_certificado' => 'float',
        'monto_certificado' => 'float',
        'total_devengado'=>'float',
        'monto_devengado' =>'float',
        'monto_liquidacion' =>'float',
        'diff_devengado' =>'float',
        'saldo_devengado' =>'float',
       ];
}