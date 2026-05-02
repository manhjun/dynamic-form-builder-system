<?php

namespace App\Services\FieldTypes\Types;

use App\Services\FieldTypes\BaseFieldType;

class FileField extends BaseFieldType
{
    public function getType(): string
    {
        return 'file';
    }

    public function buildRules(array $validation, bool $required): array
    {
        $rules = [...$this->baseRules($required), 'file'];

        if (isset($validation['mimes'])) $rules[] = "mimes:{$validation['mimes']}";
        if (isset($validation['max']))   $rules[] = "max:{$validation['max']}";

        return $rules;
    }
}
