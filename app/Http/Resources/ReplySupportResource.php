<?php

namespace App\Http\Resources;

use App\Http\Resources\UserResource;
use App\Http\Resources\SupportResource;
use Illuminate\Http\Resources\Json\JsonResource;

class ReplySupportResource extends JsonResource
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
            'description' => $this->description,
            'support' => new SupportResource($this->whenLoaded('support')),
            'user' => new UserResource($this->support),
        ];
    }
}
