<?php

namespace App\Http\Resources\v1;

use Illuminate\Http\JsonResponse;
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

        return [
            'userToken' => $this->whenNotNull($this->token),
            'userName' => $this->name,
            'userPhoto' => $this->photo,
            'userRights' => json_decode($this->rights),
        ];

    }

    public function withResponse(Request $request, JsonResponse $response)
    {
        $response->setData($this->toArray($request));
    }

}
