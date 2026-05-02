<?php

namespace App\Services\FieldTypes\Types;

use App\Services\FieldTypes\BaseFieldType;

class TextField extends BaseFieldType
{
    public function getType(): string
    {
        return 'text';
    }

    public function buildRules(array $validation, bool $required): array
    {
        $rules = [...$this->baseRules($required), 'string'];

        if (isset($validation['min']))  $rules[] = "min:{$validation['min']}";
        if (isset($validation['max']))  $rules[] = "max:{$validation['max']}";

        return $rules;
    }
}
