<?php

namespace App\GraphQL\Type;

use App\Http\Models\Pea;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class PeaType extends GraphQLType
{    
    protected $attributes = [
        'name'          => 'peaType',
        'description'   => 'User Type',    
        'model'         => Pea::class,   
    ];

    public function fields()
    {
        return [
            'id2' => ['type' => Type::string(),],
            'fuente' => ['type' => Type::nonNull(Type::string()),],
            'nrocap' => ['type' => Type::float()],
            'meta' => ['type' => Type::string(),],
            'nombres' => ['type' => Type::string(),],
            'especifica' => ['type' => Type::string()],
            'detalle' => ['type' => Type::string()],
            'situacion2' => ['type' => Type::string()],
            'basico' => ['type' => Type::string()],            
            'enero' => ['type' => Type::float(),],
            'febrero' => ['type' => Type::float(),],
            'marzo' => ['type' => Type::float(),],
            'abril' => ['type' => Type::float(),],
            'mayo' => ['type' => Type::float(),],
            'junio' => ['type' => Type::float(),],
            'julio' => ['type' => Type::float(),],
            'agosto' => ['type' => Type::float(),],
            'setiembre' => ['type' => Type::float(),],
            'octubre' => ['type' => Type::float(),],
            'noviembre' => ['type' => Type::float(),],
            'diciembre' => ['type' => Type::float(),],            
        ];
    }

    protected function resolveEmailField($root, $args)
    {
        return strtolower($root->email);
    }    
}