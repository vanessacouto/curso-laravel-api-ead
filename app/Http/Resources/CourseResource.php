<?php

namespace App\Http\Resources;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Resources\Json\JsonResource;

class CourseResource extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'modules' => ModuleResource::collection($this->whenLoaded('modules')), // só vai trazer o 'modules' nesse Resource quando usarmos o 'with' na nossa consulta (whenLoaded)
            'image' => $this->image ? Storage::url($this->image) : '', // se já tiver imagem, retorna a url da imagem
        ];
    }
}
