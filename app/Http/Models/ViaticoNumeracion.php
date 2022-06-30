<?php namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Models;

class ViaticoNumeracion extends Model {
    protected $table = 'viatico_numeracion';    
    protected $fillable = [  
        'id',      
        'viatico_id',
        'idtrabajador',
        'numero',
        'nombres',
        'cargo',
        'dni'
    ];
    
    //public function viacticoDet(){
	//	return $this->hasMany('App\Http\Models\Matriz','idtrabajador','idtrabajador');
	//}
}