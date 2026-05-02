<?php

namespace App\Services\FieldTypes\Types;

use App\Services\FieldTypes\BaseFieldType;

class DatetimeLocalField extends BaseFieldType
{
    public function getType(): string
    {
        return 'datetime-local';
    }

    public function buildRules(array $validation, bool $required): array
    {
        $rules = [...$this->baseRules($required), 'date'];

        if (isset($validation['after']))  $rules[] = "after:{$validation['after']}";
        if (isset($validation['before'])) $rules[] = "before:{$validation['before']}";

        return $rules;
    }
}
