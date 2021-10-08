<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FollowRequest extends FormRequest
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
            "user_id" => request()->user()->id
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "followable" => "required|string",
            "identifier" => "required|string", //FIXME: reikia patvarkyti kad autoriai turetu slug'a
            "user_id" => "required|exists:users,id"
        ];
    }
}
