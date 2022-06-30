<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Models;

class Trabajador extends Model {
    protected $table = 'trabajador';
    protected $unique= 'dni';
    protected $primaryKey = 'idtrabajador';
    protected $fillable = [
        'nombres',
        'email',
        'idtrabajador'
    ];
    protected $visible = [
        'dni',
        'nombres',
        'email',
        'foto',
        'idtrabajador'
    ];
    protected $hidden = [ 'password' ];
    
    public function matriz(){
		return $this->hasMany('App\Http\Models\Matriz','idtrabajador','idtrabajador');
	}
}