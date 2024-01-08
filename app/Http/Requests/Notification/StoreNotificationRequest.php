<?php

namespace App\Http\Requests\Notification;

use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreNotificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Gate::allows('notification_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'subject'   => [
                'string',
                'min:10',
                'max:255',
                'required',
            ],
            'status'    => [
                Rule::in(0, 1),
                'required',
            ],
            'published_date'  => [
                'date',
                'required',
            ],
            'message' => [
                'required',
            ],
            'published_to' => [
            ],
        ];
    }
}
