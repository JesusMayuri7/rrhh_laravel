<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class VSubsidioDevolucion extends Model {
    protected $table = 'v_subsidio_devolucion';

    protected $casts = [
        'monto_devolucion' =>'float',      
       ];

  
}