<?php

namespace App\graphql\Mutations;

use App\Models\News;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;

class CreateNewsMutation extends Mutation
{
    protected $attributes = [
        'name' => 'createNews'
    ];

    public function type(): Type
    {
        return GraphQL::type('News');
    }

    public function args(): array
    {
        return [
            'title' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The title of the news',
            ],
            'desc' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'desc of the news',
            ],
            'content' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'content of the news',
            ],
            'meta' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Meta of the news',
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $news = new News();
        $news->fill($args);
        $news->save();

        return $news;
    }
}
