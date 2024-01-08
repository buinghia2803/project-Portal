<?php

namespace App\graphql\Mutations;

use App\Models\News;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;

class DeleteNewsMutation extends Mutation
{
    protected $attributes = [
        'name' => 'deleteNews',
        'description' => 'Delete a news'
    ];

    public function type(): Type
    {
        return Type::boolean();
    }


    public function args(): array
    {
        return [
            'id' => [
                'name' => 'id',
                'type' => Type::int(),
                'rules' => ['required']
            ]
        ];
    }

    public function resolve($root, $args)
    {
        $news = News::findOrFail($args['id']);

        return  $news->delete() ? true : false;
    }
}
