<?php

namespace App\Http\Requests\Holiday;

use App\Models\Holiday;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateHolidayRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('holiday_edit');
    }

    public function rules()
    {
        return [
            'title' => [
                'required',
            ],
            'note' => [
                'required',
            ],
            'date' => [
                'date',
                'required',
            ],
        ];
    }
}
