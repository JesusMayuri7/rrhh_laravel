<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Models;

class CentroCosto extends Model {
    protected $table = 'centro_costo';
    protected $primaryKey = 'id';

    protected $visible = [
        'id',
        'descripcion'        
    ];

}