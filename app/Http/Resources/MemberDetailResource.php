<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberDetailResource extends JsonResource
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
            "nri" => $this->nri,
            "name" => $this->name,
            "address" => $this->address ?? null,
            "phone" => $this->phone ?? null,
            "photo" => url("storage/$this->photo") ?? null,
            "pob" => $this->pob ?? null,
            "dob" => Carbon::parse($this->dob)->isoFormat("D MMMM Y") ?? null,
            "gender" => $this->gender ?? null,
            "generation" => $this->generation ?? null,
            "major" => $this->major->name ?? null,
            "major_id" => $this->major_id ?? null,
            "concentration" => $this->concentration->name ?? null,
            "concentration_id" => $this->concentration_id ?? null,
            "position" => $this->position ?? null,
            "email" => $this->email ?? null,
            "instagram" => $this->instagram ?? null,
            "facebook" => $this->facebook ?? null,
        ];
    }
}
