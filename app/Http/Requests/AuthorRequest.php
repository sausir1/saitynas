<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class AuthorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        // TODO pakeisti cia dar situos reikia@!!!!
        return true;
    }

    protected function prepareForValidation()
    {

        if ($this->isMethod('POST')) {
            $this->merge([
                'slug' => Str::slug($this->name . $this->surname . ' ' . time()),
            ]);
        }
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
            "name" => $required . "string|min:3|max:100",
            "surname" => $required . "string|min:3|max:100",
            "age" => $required . "numeric|min:5|max:100",
            "slug" => $required . "string",
            "nationality" => "string|max:255",
            "about" => "string|max:600",
            "website" => "url"
        ];
    }
}
