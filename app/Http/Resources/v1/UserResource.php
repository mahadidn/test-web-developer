<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'userToken' => $this->whenNotNull($this->token),
            'userName' => $this->name,
            'userPhoto' => $this->photo,
            'userRights' => $this->rights,
        ];

    }
}
