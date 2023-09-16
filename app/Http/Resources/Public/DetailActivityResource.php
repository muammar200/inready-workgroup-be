<?php

namespace App\Http\Resources\Public;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailActivityResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'location' => $this->location,
            'image' => url("storage/$this->flayer_image")
        ];
    }
}
