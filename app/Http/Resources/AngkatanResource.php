<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AngkatanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => (int) $this->generation,
            'name' => $this->generation == 0
                ? 'Angkatan Pendiri'
                : 'Angkatan ' . $this->generation,
        ];
    }
}
