<?php

namespace App\GraphQL\Query;

use Illuminate\Support\Facades\DB;
use App\Http\Models\Pea;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Type as GraphQLType;

class PeaQuery extends Query
{
    protected $attributes = [
        'name' => 'Users query',
        'description' => 'Pea Query'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('peaType'));
    }

    public function args()
    {
        return [
            'id2' => ['name' => 'id2', 'type' => Type::string()],
            'fuente' => ['name' => 'fuente', 'type' => Type::string()],
            'meta' => ['name' => 'meta', 'type' => Type::string()],
            'especifica' => ['name' => 'especifica', 'type' => Type::string()],
            'detalle' => ['name' => 'detalle', 'type' => Type::string()],
            'nrocap' => ['name' => 'nrocap', 'type' => Type::int()],
            'nombres' => ['name' => 'nombres', 'type' => Type::string()],
            'situacion2' => ['name' => 'situacion2', 'type' => Type::string()],     
            'basico' => ['name' => 'basico','type' => Type::string()],                   
            'enero' => ['name' => 'enero', 'type' => Type::float()],
            'febrero' => ['name' => 'febrero', 'type' => Type::float()],
            'marzo' => ['name' => 'marzo', 'type' => Type::float()],
            'abril' => ['name' => 'abril', 'type' => Type::float()],
            'mayo' => ['name' => 'mayo', 'type' => Type::float()],
            'junio' => ['name' => 'junio', 'type' => Type::float()],
            'julio' => ['name' => 'julio', 'type' => Type::float()],
            'agosto' => ['name' => 'agosto', 'type' => Type::float()],
            'setiembre' => ['name' => 'setiembre', 'type' => Type::float()],
            'octubre' => ['name' => 'octubre', 'type' => Type::float()],
            'noviembre' => ['name' => 'noviembre', 'type' => Type::float()],
            'diciembre' => ['name' => 'diciembre', 'type' => Type::float()],     
            'situacion' => [
                'type' =>  Type::string(),
                'selectable'    => false]                   
        ];
    }

    public function resolve($root, $args,SelectFields $fields)
    {
        $where = function ($query) use ($args) {
           /*if (isset($args['id'])) {
                $query->where('id',$args['id']);
            }*/
        };                  
        $data = Pea::with(array_keys($fields->getRelations()))
        ->where($where)
        ->select($fields->getSelect())
        ->paginate($args['limit'] ?? 1000, ['*'], 'page', $args['page'] ?? 0);
         return $data;                   
    }
}