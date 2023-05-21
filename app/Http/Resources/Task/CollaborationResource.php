<?php

namespace App\Http\Resources\Task;

use App\Http\Resources\Attachment\AttachmentResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CollaborationResource extends JsonResource
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
            'title'             => $this->title,
            'description'       => $this->description,
            'due_date'          => $this->due_date,
            'status'            => $this->status,
            'images'            => AttachmentResource::collection($this->whenLoaded('images'))
        ];
    }
}
