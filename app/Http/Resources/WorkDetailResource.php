<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WorkDetailResource extends JsonResource
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
            "creator" => $this->member->name,
            "member_id" => $this->member_id,
            "concentration" => $this->member->concentration->name,
            "link" => $this->link,
            "image" => url("storage/$this->image"),
            "description" => $this->description,
            "created_at" => $this->created_at->isoFormat('D MMMM Y'),
            "updated_at" => $this->updated_at->isoFormat('D MMMM Y'),
        ];
    }
}
