<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id" => $this->pivot->id,
            "comment" => $this->pivot->comment,
            "created_at" => $this->pivot->created_at->format('Y-m-d H:i:s'),
            "updated_at" => $this->pivot->updated_at->format('Y-m-d H:i:s'),
            "author" => $this->name,
            "author-link" => route('users.show', $this->username)
        ];
    }
}
