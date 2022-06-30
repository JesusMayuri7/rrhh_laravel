<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class BaseCas extends Model {
    //protected $primaryKey = 'id';
    public $incrementing = false;
    protected $table = 'v_base_cas';  
    
}