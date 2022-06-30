<?php

namespace App\GraphQL\Query;

use Illuminate\Support\Facades\DB;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Query;
use GraphQL\Type\Definition\ResolveInfo;
use Rebing\GraphQL\Support\SelectFields;
use Rebing\GraphQL\Support\Type as GraphQLType;

class PresupuestoQuery extends Query
{
    protected $attributes = [
        'name' => 'Users query',
        'description' => 'Presupuesto Query'
    ];

    public function type()
    {
        return Type::listOf(GraphQL::type('presupuestoType'));
    }

    public function args()
    {
        return [
            'id' => ['name' => 'id', 'type' => Type::string()],
            'fuente' => ['name' => 'fuente', 'type' => Type::string()],
            'meta' => ['name' => 'sec_func', 'type' => Type::string()],
            'especifica' => ['name' => 'especifica', 'type' => Type::string()],
            'detalle' => ['name' => 'detalle', 'type' => Type::string()],
            'idactividad' => ['name' => 'actividad', 'type' => Type::int()],
            'actividad' => ['name' => 'actividad', 'type' => Type::string()],
            'pim' => ['name' => 'pim', 'type' => Type::float()],
            'Total' => ['name' => 'Total', 'type' => Type::float()],
            'Saldo' => ['name' => 'Saldo', 'type' => Type::float()],
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
            'analisis' => ['name' => 'analisis', 'type' => Type::float()],
            'mes' => [
                'type' => Type::int(),
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
      
      $data= DB::select('CALL sp_proyeccion_presupuestal_cap(?)',array($args['mes']));      
      return $data;           
      /*  $data = Presupuesto::with(array_keys($fields->getRelations()))
        ->where($where)
        ->select($fields->getSelect())
        ->paginate($args['limit'] ?? 100, ['*'], 'page', $args['page'] ?? 0);
         return $data;           
        */ 
        
    }
}