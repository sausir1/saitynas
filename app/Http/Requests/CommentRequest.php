<?php

namespace App\Http\Requests;

use App\Models\Book;
use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
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
        [$type, $commentable_id] = match ($this->route()->uri) {
            'api/authors/{author}/books/{book}/comments',
            'api/authors/{author}/books/{book}/comments/{comment}' =>
            ['Book', Book::where('slug', $this->route('book'))->firstOrFail()->id],
            default => null
        };
        $this->merge([
            'user_id' => $this->user()?->id,
            'commentable_type' => $type,
            'commentable_id' => $commentable_id
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
            'comment' => $required . "string|min:3|max:1000",
            'commentable_type' => $required . "string",
            'commentable_id' => $required . "numeric",
            'user_id' => $required . "exists:users,id"
        ];
    }
}
