<?php

namespace App\Http\Requests\RegisterOt;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class CreateRegisterOt extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('member_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'request_type' => [
                Rule::in(5),
            ],
            'request_for_date' => [
                'date',
                'required'
            ],
            'check_in' => [
                'required'
            ],
            'check_out' => [
                'required'
            ],
            'request_ot_time' => [
                'string',
                'required',
                'max:5',
            ],
            'reason' => [
                'string',
                'required',
                'max:100',
            ]
        ];
    }
}
