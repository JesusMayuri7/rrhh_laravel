<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class ConvocatoriasDB extends Model {
    protected $primaryKey = 'id';
    public $incrementing = true;
    protected $table = 'convocatorias';  
}