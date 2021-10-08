<?php

namespace App\Http\Requests;

use App\Models\Book;
use Illuminate\Foundation\Http\FormRequest;

class ReadingsUpdateRequest extends FormRequest
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
        return [
            'current_page' => 'numeric|min:0',
            'finished_at' => 'nullable|date',
            'started_at' => 'date|nullable',
            'owns' => 'boolean'
        ];
    }
}
