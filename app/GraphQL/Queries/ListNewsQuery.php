<?php

namespace App\graphql\Queries;

use App\Models\News;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Query;

class ListNewsQuery extends Query
{
    protected $attributes = [
        'name' => 'listNews',
    ];

    public function type(): Type
    {
        return Type::listOf(GraphQL::type('News'));
    }

    public function resolve($root, $args)
    {
        return News::all();
    }
}
