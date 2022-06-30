<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class CasAnalisis extends Model {
    protected $table = 'casanalisis';

    public function casanalisisdetalle()
        {
            return $this->hasMany('\App\Http\Models\CasAnalisisDetalle','Id2','Id');
        }

  
}