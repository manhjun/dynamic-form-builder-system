<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FormDetailResource extends JsonResource
{
    public function toArray($request): array
    {
        $activeVersion = $this->versions->first();

        return [
            'id'          => $this->id,
            'title'       => $this->title,
            'description' => $this->description,
            'order'       => $this->order,
            'version'     => $activeVersion?->version,
            'status'      => $activeVersion?->status,
            'published_at' => $activeVersion?->published_at,
            'fields'      => FieldResource::collection(
                $activeVersion?->fields ?? []
            ),
            'created_at'  => $this->created_at,
        ];
    }
}
