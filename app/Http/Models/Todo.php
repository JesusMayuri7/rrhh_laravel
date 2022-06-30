<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Todo extends Model {
    protected $table = 'todo';
    protected $primaryKey='idtodo';
    protected $fillable = [
        'nivel',
        'texto',
        'fecha',
        'titulo',
        'tipo',
        'ejecutado'
    ];
    
 
}