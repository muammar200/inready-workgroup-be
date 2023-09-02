<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "category" => $this->category->name,
            "writer" => $this->creator->username,
            "image" => url("storage/$this->image"),
            "content" => $this->content,
            "created_at" => $this->created_at->isoFormat('D MMMM Y'),
            "updated_at" => $this->updated_at->isoFormat('D MMMM Y'),
        ];
    }
}
