<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AgendaDetailResource extends JsonResource
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
            "location" => $this->location,
            "time" => $this->time,
            "created_at" => $this->created_at->isoFormat('D MMMM Y'),
            "updated_at" => $this->updated_at->isoFormat('D MMMM Y'),
        ];
    }
}
