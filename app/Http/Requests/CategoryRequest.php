<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class CategoryRequest extends FormRequest
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


    public function prepareForValidation()
    {
        if ($this->isMethod('POST')) {
            $this->merge([
                'created_at' => Carbon::now()->toDateTimeString(),
                'slug' => Str::slug($this->name)
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
            'name' => $required . 'string|min:2|max:100|unique:categories,name',
            'slug' => $required . 'string|min:2|max:100',
            'description' => $required . 'string|max:2000|min:2',
            'created_at' => $required . 'date'
        ];
    }
}
