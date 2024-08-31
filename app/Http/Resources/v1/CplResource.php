<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CplResource extends JsonResource
{

    public static $wrap = 'cpl';

    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);
        return [
            'kodecpl' => $this->kode_cpl,
            'deskripsi' => $this->deskripsi,
        ];

    }
}
