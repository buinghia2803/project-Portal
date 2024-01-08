<?php

namespace App\Http\Requests\PointAction;

use App\Models\PointAction;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class PointActionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('member_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'action'   => [
                'string',
                'min:6',
                'max:100',
                'required',
            ],
            'point' => [
                'required',
                'numeric'
            ]
        ];
    }
}
