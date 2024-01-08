<?php

namespace App\graphql\Mutations;

use App\Models\News;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class UpdateNewsMutation extends Mutation
{
    protected $attributes = [
        'name' => 'updateNews'
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
                'type' =>  Type::nonNull(Type::int()),
            ],
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
                'description' => 'created_at is the news was created',
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $news = News::findOrFail($args['id']);
        $news->fill($args);
        $news->save();

        return $news;
    }
}
