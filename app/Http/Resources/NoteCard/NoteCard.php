<?php

namespace App\Http\Resources\NoteCard;

use Illuminate\Http\Resources\Json\JsonResource;

class NoteCard extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'isDefault' => $this->is_default,
        ];
    }
}
