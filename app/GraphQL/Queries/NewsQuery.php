<?php

namespace App\GraphQL\Queries;

use App\Models\News;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class NewsQuery extends Query
{
    protected $attributes = [
        'name' => 'news',
    ];

    public function type(): Type
    {
        return GraphQL::type('News');
    }

    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'rules' => ['required']
            ],
        ];
    }

    public function resolve($root, $args)
    {
        return News::findOrFail($args['id']);
    }
}
