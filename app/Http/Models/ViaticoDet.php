<?php namespace App\Http\Models;
use Illuminate\Database\Eloquent\Model;
use App\Http\Models;

class ViaticoDet extends Model {
    protected $table = 'viatico_trabajador';    
    protected $fillable = [  
        'id',      
        'viatico_id',
        'idtrabajador',
        'cargo'
    ];
    
    //public function viacticoDet(){
	//	return $this->hasMany('App\Http\Models\Matriz','idtrabajador','idtrabajador');
	//}
}