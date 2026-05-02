<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubmissionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'form_id'    => $this->form_id,
            'version'    => $this->formVersion->version,
            'values'     => $this->values->map(fn($v) => [
                'field'  => $v->field->name,
                'label'  => $v->field->label,
                'value'  => $v->value,
            ]),
            'created_at' => $this->created_at,
        ];
    }
}
