<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class LiquidacionReportSiafAll extends Model {       
    protected $table = 'v_liquidacion_rpt_siaf_all';  

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