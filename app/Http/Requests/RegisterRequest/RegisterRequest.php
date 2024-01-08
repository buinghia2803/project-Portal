<?php

namespace App\Http\Requests\RegisterRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Gate;
use Symfony\Component\HttpFoundation\Response;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // abort_if(Gate::denies('member_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

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
                Rule::in(1,2,3,4,5),
                'required'
            ],
            'request_for_date' => [
                'date',
                'required'
            ],
            
            //type 1
            'check_in' => [
                'required_if:request_type,==,1'
            ],
            'check_out' => [
                'required_if:request_type,==,1'
            ],
            'error_count' => [
                'required_if:request_type,==,1'
            ],
            //end type 1

            // //type 2,3
            'leave_start' => [
                'required_if:request_type,2,3'
            ],
            'leave_end' => [
                'required_if:request_type,2,3'
            ],
            'leave_time' => [
                'required_if:request_type,2,3'
            ],
            //end type 2,3

            //type 4
            'compensation_time' => [
                'string',
                'required_if:request_type,==,4'
            ],
            'compensation_date' => [
                'date',
                'required_if:request_type,==,4'
            ],
            //end type 4

            //type 5
            'request_ot_time' => [
                'required_if:request_type,==,5'
            ],
            //end type 5
            
            'reason' => [
                'string',
                'required',
                'max:100',
            ],
        ];
    }
}
