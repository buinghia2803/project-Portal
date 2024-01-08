<?php

namespace App\Http\Requests\RequestAdmin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;
use Symfony\Component\HttpFoundation\Response;

class CreateRequestAdmin extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        abort_if(Gate::denies('request_admin_update'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
                'in:2,-1',
            ],
            'admin_approved_status' => [
                'integer',
                'required',
                'in:1,-1',
            ]
        ];
    }
}
