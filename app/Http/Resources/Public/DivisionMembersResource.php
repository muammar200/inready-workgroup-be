<?php

namespace App\Http\Resources\Public;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DivisionMembersResource extends JsonResource
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
            'is_division_head' => $this->is_division_head,
            'concentration' => $this->member->concentration->name,
            'ig' => $this->member->instagram,
            'fb' => $this->member->facebook,
            'email' => $this->member->email,
            'photo' => url("storage/" . $this->member->photo)
        ];
    }
}
