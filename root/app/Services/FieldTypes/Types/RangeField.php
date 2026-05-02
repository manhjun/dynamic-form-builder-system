<?php

namespace App\Services\FieldTypes\Types;

use App\Services\FieldTypes\BaseFieldType;

class RangeField extends BaseFieldType
{
    public function getType(): string
    {
        return 'range';
    }

    public function buildRules(array $validation, bool $required): array
    {
        $rules = [...$this->baseRules($required), 'numeric'];

        if (isset($validation['min'])) $rules[] = "min:{$validation['min']}";
        if (isset($validation['max'])) $rules[] = "max:{$validation['max']}";

        return $rules;
    }
}
