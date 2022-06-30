<?php

namespace App\GraphQL\Type;

use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class PresupuestoType extends GraphQLType
{    
    protected $attributes = [
        'name'          => 'presupdduestoType',        
    ];

    public function fields()
    {
        return [
            'id' => ['type' => Type::string(),],
            'fuente' => ['type' => Type::nonNull(Type::string()),],
            'pim' => ['type' => Type::float()],
            'meta' => ['type' => Type::string(),],
            'especifica' => ['type' => Type::string()],
            'detalle' => ['type' => Type::string()],
            'idactividad' => ['type' => Type::int()],
            'actividad' => ['type' => Type::string()],
            'Total' => ['type' => Type::float(),],                        
            'Saldo' => ['type' => Type::float(),],
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
            'analisis' => ['type' => Type::float(),],
        ];
    }

    // If you want to resolve the field yourself, you can declare a method
    // with the following format resolve[FIELD_NAME]Field()
    protected function resolveEmailField($root, $args)
    {
        return strtolower($root->email);
    }    
}