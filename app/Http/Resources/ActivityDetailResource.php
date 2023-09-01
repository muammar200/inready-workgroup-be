<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ActivityDetailResource extends JsonResource
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
            "time" => Carbon::parse($this->time)->isoFormat("D MMMM Y"),
            "registration_link" => $this->registration_link,
            "flayer_image" => url("storage/$this->flayer_image"),
            "description" => $this->description,
            "created_at" => $this->created_at->isoFormat("D MMMM Y"),
            "updated_at" => $this->updated_at->isoFormat("D MMMM Y"),
        ];
    }
}
