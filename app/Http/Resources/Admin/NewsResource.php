<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @OA\Schema(
 *     title="NewsResource",
 *     description="News resource",
 *     @OA\Xml(
 *         name="NewsResource"
 *     )
 * )
 */
class NewsResource extends JsonResource
{
    /**
     * @OA\Property(
     *     title="Data",
     *     description="Data wrapper"
     * )
     *
     * @var \App\Models\News[]
     */
    private $data;

    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
