<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Task\CollaborationResource;
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
            'id'                => $this->id,
            'name'              => $this->name,
            'email'             => $this->email,
            'tasks'             => CollaborationResource::collection($this->tasks),
            'collaborations'    => CollaborationResource::collection($this->collaborations),
            'created_at'        => date('Y-M-d h:i:s A', strtotime($this->created_at))
        ];
    }
}
