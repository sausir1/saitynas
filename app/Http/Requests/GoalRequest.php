<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoalRequest extends FormRequest
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

    protected function prepareForValidation()
    {
        $this->merge([
            'user_id' => $this->user()->id,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $required = $this->isMethod('POST') ? 'required|' : '';
        return [
            "until" => 'date',
            "goal" => $required . 'integer|min:1',
            "progress" => 'integer|min:0',
            "name" => $required . "string|max:100|min:3",
            "user_id" => "required|exists:users,id"
            //
        ];
    }
}
