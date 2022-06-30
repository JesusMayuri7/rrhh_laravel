<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Escala extends Model {
    protected $primaryKey = 'id';
    //public $incrementing = false;
    protected $table = 'escala';  
    protected $appends = ['full_escala'];

    public function getFullEscalaAttribute()
    {
        return strtoupper($this->cargo.' - '.$this->desc_escala);
    }
}