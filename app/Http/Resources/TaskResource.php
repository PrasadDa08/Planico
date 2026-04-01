<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'assigned_to' => new UserResource($this->whenLoaded('assignedTo')),
            'created_by' => new UserResource($this->whenLoaded('createdBy')),
            'name' => $this->name,
            'description' => $this->description,
            'priority' => $this->priority,
            'due_date' => $this->due_date?->format('d M Y'),
            'position' => $this->position,
            'created_at' => $this->created_at->format('d M Y'),
            'board' => new BoardResource($this->whenLoaded('board')),
            'list' => new TaskListResource($this->whenLoaded('list'))
        ];
    }
}
