<?php

namespace App\Http\Requests\RequestManager;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CreateRequestManager extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('request_manager_update'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
            'status' => [
                'integer',
                'in:1,-1',
            ],
            'manager_confirmed_status' => [
                'integer',
                'required',
                'in:1,-1',
            ]
        ];
    }
}
