<?php

namespace App\Http\Resources\Public;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NextBlogResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'creator' => $this->creator->username,
            'updated_at' => Carbon::parse($this->created_at)->format('d m Y'),
            'title' => $this->title,
        'content' => $this->content,
        ];
    }
}
