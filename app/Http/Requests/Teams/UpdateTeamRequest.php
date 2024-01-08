<?php

namespace App\Http\Requests\Teams;

use App\Models\Team;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

/**
 * @OA\Schema(
 *      title="Update News request",
 *      description="Update News request body data",
 *      type="object",
 *      required={"title"}
 * )
 */
class UpdateTeamRequest extends FormRequest
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
        return Gate::allows('team_edit');
    }

    public function rules()
    {
        return [
            'team_name'   => [
                'string',
                'min:5',
                'max:255',
                'required',
                'unique:teams,team_name,' . request()->route('team')->id,
            ],
            'leader_id'    => [
                'required',
                'integer',
            ],
            'teamMembers.*' => [
                'integer',
            ],
            'teamMembers' => [
                'required',
                'array',
            ],
        ];
    }
}
