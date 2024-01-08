<?php

namespace App\GraphQL\Types;

use App\Models\News;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Type as GraphQLType;

class NewsType extends GraphQLType
{
    protected $attributes = [
        'name' => 'News',
        'description' => 'Get news',
        'model' => News::class
    ];


    public function fields(): array
    {
        return [
            'id' => [
                'type' => Type::nonNull(Type::int()),
                'description' => 'Id of a particular news',
            ],
            'title' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'The title of the news',
            ],
            'desc' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Desc of the news',
            ],
            'content' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Content of the news',
            ],
            'meta' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'Meta of the news',
            ],
            'created_at' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'created_at is the news was created',
            ],
            'updated_at' => [
                'type' => Type::nonNull(Type::string()),
                'description' => 'updated_at is the news was updated',
            ]
        ];
    }
}
