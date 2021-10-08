<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ReadingsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $this->load('author');
        return [
            'book_id' => $this->id,
            'title' => $this->title,
            'book_link' => route('authors.books.show', [$this->author->id, $this->slug]),
            'pages' => $this->pages,
            'cover' => $this->cover,
            'author' => $this->author->name,
            'author_link' => route('authors.show', $this->author->id),
            'price' => $this->price,
            'current_page' => $this->pivot->current_page,
            'started_at' => $this->pivot->started_at,
            'finished_at' => $this->pivot->finished_at,
            'owns' => $this->pivot->owns == 1,

        ];
    }
}
