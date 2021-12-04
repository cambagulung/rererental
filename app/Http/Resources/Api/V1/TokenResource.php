<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Resources\Json\JsonResource;

class TokenResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            "id"                => $this->id,
            "tokenable"         => new UserResource($this->tokenable),
            "name"              => $this->name,
            "abilities"         => $this->abilities,
            "last_used_at"      => $this->last_used_at,
            "created_at"        => $this->created_at,
            "updated_at"        => $this->created_at,
        ];
    }
}
