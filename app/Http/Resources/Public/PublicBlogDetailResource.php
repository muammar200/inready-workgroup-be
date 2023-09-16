<?php

namespace App\Http\Resources\Public;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicBlogDetailResource extends JsonResource
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
            'creator' => $this->creator->username,
            'image' => url("storage/$this->image"),
            'updated_at' => Carbon::parse($this->update_at)->format('d M Y')
        ];
    }
}
