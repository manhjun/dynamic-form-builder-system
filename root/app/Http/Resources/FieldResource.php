<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FieldResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'label'       => $this->label,
            'type'        => $this->type,
            'required'    => $this->required,
            'sort_order'  => $this->sort_order,
            'placeholder' => $this->placeholder,
            'help_text'   => $this->help_text,
            'options'     => $this->options,
            'validation'  => $this->validation,
        ];
    }
}
