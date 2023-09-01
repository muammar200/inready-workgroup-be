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
            "photo" => url("storage/$this->photo"),
            "address" => $this->address,
            "pob" => $this->pob,
            "dob" => Carbon::parse($this->dob)->isoFormat("D MMMM Y"),
            "gender" => $this->gender,
            "generation" => $this->generation,
            "major" => $this->major->name,
            "concentration" => $this->concentration->name,
            "position" => $this->position,
            "phone" => $this->phone,
            "email" => $this->email,
            "instagram" => $this->instagram,
            "facebook" => $this->facebook,
        ];
    }
}
