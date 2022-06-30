<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model {
    //protected $primaryKey = 'id';
    public $incrementing = false;
    protected $table = 'v_ordenes_listar';    

}