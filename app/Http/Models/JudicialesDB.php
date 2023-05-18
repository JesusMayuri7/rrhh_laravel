<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class JudicialesDB extends Model {
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $table = 'judiciales';  
    
}