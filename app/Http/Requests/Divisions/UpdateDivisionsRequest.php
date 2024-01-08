<?php

namespace App\Http\Requests\Divisions;

use App\Models\Division;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

/**
 * @OA\Schema(
 *      title="Update News request",
 *      description="Update News request body data",
 *      type="object",
 *      required={"title"}
 * )
 */
class UpdateDivisionsRequest extends FormRequest
{
    /**
     * @OA\Property(
     *      title="title",
     *      description="Title of the news",
     *      example="A nice news"
     * )
     *
     * @var string
     */
    public $title;

    /**
     * @OA\Property(
     *      title="desc",
     *      description="Description of the news",
     *      example="This is news' description"
     * )
     *
     * @var string
     */
    public $desc;

    /**
     * @OA\Property(
     *      title="meta",
     *      description="Meta of the news",
     *      example="This is news' meta"
     * )
     *
     * @var string
     */
    public $meta;

    /**
     * @OA\Property(
     *      title="content",
     *      description="Content of the news",
     *      example="This is news' content"
     * )
     *
     * @var string
     */
    public $content;

    public function authorize()
    {
        return Gate::allows('division_edit');
    }

    public function rules()
    {
        return [
            'division_name'   => [
                'string',
                'min:5',
                'max:255', 
                'required',
                'unique:divisions,division_name,' . request()->route('division')->id,
            ],
            'dm_id'    => [
                'required',
                'integer',
            ],
            'divisionMembers.*' => [
                'integer',
            ],
            'divisionMembers' => [
                'required',
                'array',
            ],
        ];
    }
}
