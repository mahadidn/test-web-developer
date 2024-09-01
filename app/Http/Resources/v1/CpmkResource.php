<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CpmkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "kodecpl" => $this->kode_cpl,
            "kodecpmk" => $this->kode_cpmk,
            "deskripsi" => $this->deskripsi
        ];

    }
}
