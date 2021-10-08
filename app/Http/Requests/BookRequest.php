<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class BookRequest extends FormRequest
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
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation()
    {
        $id = $this->route()->author ? $this->route()->author : $this->author_id;
        if (!$this->slug) {
            $this->merge([
                'slug' => Str::slug($this->title . ' ' . time()),
                'author_id' => $id,
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
        $shouldBeUnique = $this->isMethod("POST") ? '|unique:books,slug' : '';
        $required = $this->isMethod("POST") ? "required|" : '';
        return [
            "title" => $required . "string|min:2|max:255",
            "slug" => $required . "string|max:255" . $shouldBeUnique,
            "price" => $required . "numeric|min:0.1",
            "about" => $required . "string|max:1000",
            "cover" => "nullable|image",
            "pages" => $required . "integer|min:1",
            "author_id" => $required . "exists:authors,id",
            "category_id" => $required . "exists:categories,id"
        ];
    }
}
