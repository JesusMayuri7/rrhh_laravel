<?php namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Presupuesto extends Model {
    protected $table = 'presupuestodet3';     

    protected $casts = [
        'mto_pia'=> 'float',
        'mto_modificaciones'=> 'float',
        'mto_pim'=> 'float',
        'mto_certificado'=> 'float',
        'mto_compro_anual'=> 'float',
        'mto_at_comp_01'=> 'float',
        'mto_at_comp_02'=> 'float',
        'mto_at_comp_03'=> 'float',
        'mto_at_comp_04'=> 'float',
        'mto_at_comp_05'=> 'float',
        'mto_at_comp_06'=> 'float',
        'mto_at_comp_07'=> 'float',
        'mto_at_comp_08'=> 'float',
        'mto_at_comp_09'=> 'float',
        'mto_at_comp_10'=> 'float',
        'mto_at_comp_11'=> 'float',
        'mto_at_comp_12'=> 'float',
        'mto_devenga_01'=> 'float',
        'mto_devenga_02'=> 'float',
        'mto_devenga_03'=> 'float',
        'mto_devenga_04'=> 'float',
        'mto_devenga_05'=> 'float',
        'mto_devenga_06'=> 'float',
        'mto_devenga_07'=> 'float',
        'mto_devenga_08'=> 'float',
        'mto_devenga_09'=> 'float',
        'mto_devenga_10'=> 'float',
        'mto_devenga_11'=> 'float',
        'mto_devenga_12'=> 'float',
        'mto_girado_01'=> 'float',
        'mto_girado_02'=> 'float',
        'mto_girado_03'=> 'float',
        'mto_girado_04'=> 'float',
        'mto_girado_05'=> 'float',
        'mto_girado_06'=> 'float',
        'mto_girado_07'=> 'float',
        'mto_girado_08'=> 'float',
        'mto_girado_09'=> 'float',
        'mto_girado_10'=> 'float',
        'mto_girado_11'=> 'float',
        'mto_girado_12'=> 'float',
        'mto_pagado_01'=> 'float',
        'mto_pagado_02'=> 'float',
        'mto_pagado_03'=> 'float',
        'mto_pagado_04'=> 'float',
        'mto_pagado_05'=> 'float',
        'mto_pagado_06'=> 'float',
        'mto_pagado_07'=> 'float',
        'mto_pagado_08'=> 'float',
        'mto_pagado_09'=> 'float',
        'mto_pagado_10'=> 'float',
        'mto_pagado_11'=> 'float',
        'mto_pagado_12'=> 'float'
    ];


}