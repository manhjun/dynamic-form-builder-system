<?php

namespace App\Services\FieldTypes\Types;

use App\Services\FieldTypes\BaseFieldType;

class SelectField extends BaseFieldType
{
    public function getType(): string
    {
        return 'select';
    }

    public function buildRules(array $validation, bool $required): array
    {
        $rules = $this->baseRules($required);

        if (isset($validation['options'])) {
            $options = implode(',', $validation['options']);
            $rules[] = "in:{$options}";
        }

        return $rules;
    }
}
