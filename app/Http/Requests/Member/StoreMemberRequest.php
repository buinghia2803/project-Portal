<?php

namespace App\Http\Requests\Member;

use App\Models\Member;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class StoreMemberRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('member_create');
    }

    public function rules()
    {
        return [
            'full_name'     => [
                'string',
                'min:8',
                'max:100',
                'required',
            ],
            'email'    => [
                'string',
                'max: 80',
                'required',
                'unique:members',
            ],
            'password' => [
                'required',
            ],
            'roles.*'  => [
                'integer',
            ],
            'roles'    => [
                'required',
                'array',
            ],
            'other_email' => [
                'string',
                'max:50',
                'required',
                'unique:members',
            ],
            'phone' => [
                'string',
                'max:20',
                'required'
            ],
            'gender' => [
                Rule::in(0, 1),
                'required'
            ],
            'other_email' => [
                'string',
                'max:50',
                'required'
            ],
            'marital_status' => [
                Rule::in(1, 2, 3, 4),
                'required'
            ],
            'birth_date' => [
                'date',
                'required',
            ],
            'permanent_address' => [
                'string',
                'max:255',
                'required'
            ],
            'temporary_address' => [
                'string',
                'max:255',
                'required'
            ],
            'identity_number' => [
                'string',
                'max:12',
                'required'
            ],
            'identity_card_date' => [
                'date',
                'required'
            ],
            'identity_card_place' => [
                'string',
                'max:50',
                'required'
            ],
            'nationality' => [
                'string',
                'max:50',
                'required'
            ],
            'emergency_contact_name' => [
                'string',
                'max:70',
                'required'
            ],
            'emergency_contact_relationship' => [
                'string',
                'max:50',
                'required'
            ],
            'emergency_contact_number' => [
                'string',
                'max:20',
                'required'
            ],
            'bank_name' => [
                'string',
                'max:70',
                'required'
            ],
            'bank_account' => [
                'string',
                'max:20',
                'required'
            ],
            'status' => [
                Rule::in(-1, 0, 1, 2, 3, 4, 5),
                'required'
            ],

        ];
    }
}
