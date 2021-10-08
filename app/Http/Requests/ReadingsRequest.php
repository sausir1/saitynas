<?php

namespace App\Http\Requests;

use App\Models\Book;
use GuzzleHttp\Psr7\Request;
use Illuminate\Foundation\Http\FormRequest;

class ReadingsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user();
    }

    public function prepareForValidation()
    {
        if (!$this->has('slug')) {
            abort(422, "Please provide a book slug!");
        }
        $book = Book::where('slug', $this->slug)->firstOrFail();
        $this->merge([
            'book_id' => $book->id,
            'total_pages' => $book->pages
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
            'book_id' => 'required|exists:books,id',
            'total_pages' => 'required|min:0',
            'current_page' => 'required|numeric|min:0',
            'finished_at' => 'nullable|date',
            'started_at' => 'date|nullable',
            'owns' => 'boolean'
        ];
    }
}
