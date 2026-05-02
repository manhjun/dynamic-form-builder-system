<?php

namespace App\Services\FieldTypes\Types;

use App\Services\FieldTypes\BaseFieldType;

class NumberField extends BaseFieldType
{
    public function getType(): string
    {
        return 'number';
    }

    public function buildRules(array $validation, bool $required): array
    {
        $rules = [...$this->baseRules($required), 'numeric'];

        if (isset($validation['min']))      $rules[] = "min:{$validation['min']}";
        if (isset($validation['max']))      $rules[] = "max:{$validation['max']}";
        if (isset($validation['integer']))  $rules[] = 'integer';

        return $rules;
    }
}
