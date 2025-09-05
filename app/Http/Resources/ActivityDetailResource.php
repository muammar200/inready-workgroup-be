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
            'images' => collect($this->images)->map(function ($image) {
                return url('storage/' . $image);
            })->all(),
            "description" => $this->description,
            "created_at" => $this->created_at->isoFormat("D MMMM Y"),
            "updated_at" => $this->updated_at->isoFormat("D MMMM Y"),
        ];
    }
}
