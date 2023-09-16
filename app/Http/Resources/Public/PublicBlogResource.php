<?php

namespace App\Http\Resources\Public;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicBlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'category' => $this->category->name,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
        ];
    }
}
