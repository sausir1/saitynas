<?php

namespace App\Http\Requests;

use Illuminate\Support\Str;
use Illuminate\Foundation\Http\FormRequest;

class BadgeRequest extends FormRequest
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

    public function rules()
    {
        $required = $this->isMethod('POST') ? 'required|' : '';
        return [
            "criteria" => $required . "json",
            "name" => $required . "min:5|max:100",
            "image" => $required . "string",
            "for" => $required . "string|min:5|max:500"
        ];
    }
}
