<?php

namespace App\Http\Requests;

use App\Models\Reading;
use Illuminate\Foundation\Http\FormRequest;

class NoteRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user() && Reading::where('user_id', $this->user()->id)->where('book_id', $this->route('reading'))->first();
    }


    public function prepareForValidation()
    {
        $this->merge(['reading_id' => $this->route('reading')]);
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'note' => 'required|string|min:1|max:500',
            'reading_id' => 'required|exists:readings,book_id'
        ];
    }
}
