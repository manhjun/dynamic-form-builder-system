<?php

namespace App\Services\FieldTypes\Types;

use App\Services\FieldTypes\BaseFieldType;

class CheckboxField extends BaseFieldType
{
    public function getType(): string
    {
        return 'checkbox';
    }

    public function buildRules(array $validation, bool $required): array
    {
        return [...$this->baseRules($required), 'boolean'];
    }
}
