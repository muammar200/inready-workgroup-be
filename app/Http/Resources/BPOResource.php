<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BPOResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            'id' => $this->id,
            'name' => $this->member->name,
            'is_division_head' => $this->is_division_head ?? false,
            'presidium' => $this->position->name ?? null,
            'division' => $this->division->name ?? null,
        ];
    }
}
