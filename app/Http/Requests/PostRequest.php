<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Ramsey\Uuid\Nonstandard\Uuid;

class PostRequest extends FormRequest
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
            'slug' => Str::slug($this->title . ' ' . time()),
            'user_id' => $this->user() ? $this->user()->id : -1
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $required = $this->isMethod("POST") ? "required|" : '';
        return [
            "title" => $required . "string|max:255|min:3",
            "slug" => $required . "string|unique:posts,slug",
            "body" => $required . "string|max:1000|min:5",
            "user_id" => "required|exists:users,id"
        ];
    }
}
