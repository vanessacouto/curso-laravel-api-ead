<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Http\Resources\UserResource;
use App\Http\Resources\LessonResource;
use App\Http\Resources\ReplySupportResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SupportResource extends JsonResource
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
            'status' => $this->status,
            'status_label' => $this->statusOptions[$this->status] ?? 'Status Not Found', // se existe status retorna, senão retorna 'not found'
            'description' => $this->description,
            'user' => new UserResource($this->user),
            'lesson' => new LessonResource($this->whenLoaded('lessons')),
            'replies' => ReplySupportResource::collection($this->replies), // sempre trará as 'replies', mesmo que não exista uma reply para um 'support'
            //'replies' => ReplySupportResource::collection($this->whenLoaded('replies')),
            'dt_updated' => Carbon::make($this->updated_at)->format('Y-m-d H:i:s'),
        ];
    }
}
