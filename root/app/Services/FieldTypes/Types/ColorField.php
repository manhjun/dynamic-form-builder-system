<?php

namespace App\Services\FieldTypes\Types;

use App\Services\FieldTypes\BaseFieldType;

class ColorField extends BaseFieldType
{
    public function getType(): string
    {
        return 'color';
    }

    public function buildRules(array $validation, bool $required): array
    {
        return [...$this->baseRules($required), 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'];
    }
}
