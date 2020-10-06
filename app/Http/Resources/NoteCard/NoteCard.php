<?php

namespace App\Http\Resources\NoteCard;

use Illuminate\Http\Resources\Json\JsonResource;

class NoteCard extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'country' => $this->relationLoaded('country') ? $this->country->name : null,
            'region' => $this->relationLoaded('region') ? optional($this->region)->name : null,
            'locality' => $this->relationLoaded('locality') ? optional($this->locality)->name : null,
            'city' => $this->city,
            'street' => $this->street,
            'additional' => $this->resource->additional,
            'postcode' => $this->postcode,
            'notes' => $this->notes,
            'isDefault' => $this->is_default,
            'isShipping' => $this->is_shipping,
            'isBilling' => $this->is_billing,
            'label' => $this->relationLoaded('region') && $this->relationLoaded('locality')
                ? $this->label()
                : null,
        ];
    }
}
