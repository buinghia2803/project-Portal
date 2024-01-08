<?php

namespace App\Http\Requests\Leave;

use App\Models\Leave;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreLeaveRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('leave_create');
    }

    public function rules()
    {
        return [
            'quota' => [
                'integer',
                'required',
            ],
            'note' => [
                'required',
            ],
            'member_id' => [
                'required',
            ],
        ];
    }
}
