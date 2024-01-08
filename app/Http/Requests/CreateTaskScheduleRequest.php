<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateTaskScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $validation = [
            'task_id' => ['required'],
            'description' => ['required'],
            'status' => ['required'],
            'type' => ['required'],
            'items' => ['required', 'array'],
            'user_id' => ['required' , 'array'],
        ];

        if($this->get('type') == 'daily') {
            $validation['items.*.day'] = ['required'];
            $validation['items.*.hour'] = ['required'];
        } else if ($this->get('type') == 'monthly') {
            $validation['items.*.date'] = ['required'];
            $validation['items.*.hour'] = ['required'];
        } else if ($this->get('type') == 'yearly') {
            $validation['items.*.month'] = ['required'];
            $validation['items.*.date'] = ['required'];
            $validation['items.*.hour'] = ['required'];
        }

        return $validation;
    }
}
