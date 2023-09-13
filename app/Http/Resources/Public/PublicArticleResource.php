<?php

namespace App\Http\Resources\Public;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicArticleResource extends JsonResource
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
            "slug" => $this->slug,
            "title" => $this->title,
            "content" => $this->content,
            "image" => url("storage/$this->image"),
            "created_by" => $this->creator->member->name,
            "created_at" => $this->created_at->format("M d, Y"),
        ];
    }
}
