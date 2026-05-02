<?php

namespace App\Services\FieldTypes\Types;

use App\Services\FieldTypes\BaseFieldType;

class UrlField extends BaseFieldType
{
    public function getType(): string
    {
        return 'url';
    }

    public function buildRules(array $validation, bool $required): array
    {
        return [...$this->baseRules($required), 'url'];
    }
}
