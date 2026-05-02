<?php

namespace App\Services\FieldTypes\Types;

use App\Services\FieldTypes\BaseFieldType;

class DateField extends BaseFieldType
{
    public function getType(): string
    {
        return 'date';
    }

    public function buildRules(array $validation, bool $required): array
    {
        $rules = [...$this->baseRules($required), 'date'];

        if (isset($validation['no_past']) && $validation['no_past'])    $rules[] = 'after_or_equal:today';
        if (isset($validation['no_future']) && $validation['no_future']) $rules[] = 'before_or_equal:today';
        if (isset($validation['after']))    $rules[] = "after:{$validation['after']}";
        if (isset($validation['before']))   $rules[] = "before:{$validation['before']}";

        return $rules;
    }
}
