<?php namespace App\Http\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class CasAnalisisDetalle extends Model {
    protected $table = 'casanalisisdetalle';
    protected $visible = [
        'dni',
        'nombre',
        'Inicio',
        'Fin',
        'cargo',
        'establecimiento',
        'enero',
        'febrero',
        'Marzo',
        'Abril',
        'Mayo',
        'Junio',
        'Julio',
        'Agosto',        
        'Setiembre',
        'Octubre',
        'Noviembre',
        'Diciembre'
    ];
  
}