<?php

namespace App\Http\Resources\Public;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PresidiumResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->member->name,
            'position' => $this->name,
            'concentration' => $this->member->concentration->name,
            'photo' => url("storage/" . $this->member->photo)
        ];
    }
}
