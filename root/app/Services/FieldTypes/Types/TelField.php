<?php

namespace App\Services\FieldTypes\Types;

use App\Services\FieldTypes\BaseFieldType;

class TelField extends BaseFieldType
{
    public function getType(): string
    {
        return 'tel';
    }

    public function buildRules(array $validation, bool $required): array
    {
        $rules = [...$this->baseRules($required), 'string'];

        if (isset($validation['regex'])) $rules[] = "regex:{$validation['regex']}";

        return $rules;
    }
}
