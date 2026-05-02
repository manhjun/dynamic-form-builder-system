<?php

namespace App\Services\FieldTypes\Types;

use App\Services\FieldTypes\BaseFieldType;

class EmailField extends BaseFieldType
{
    public function getType(): string
    {
        return 'email';
    }

    public function buildRules(array $validation, bool $required): array
    {
        return [...$this->baseRules($required), 'email'];
    }
}
