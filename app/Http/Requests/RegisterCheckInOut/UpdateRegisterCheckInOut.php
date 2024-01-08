<?php

namespace App\Http\Requests\RegisterCheckInOut;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\Response;

class UpdateRegisterCheckInOut extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('member_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
                Rule::in(1),
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
            'reason' => [
                'string',
                'required',
                'max:100',
            ]
        ];
    }
}
