<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class CodigosAirhsp extends Model {
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false; 
    protected $table = 'v_codigos_air';  
    
}