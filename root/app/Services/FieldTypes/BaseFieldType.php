<?php

namespace App\Services\FieldTypes;

use App\Services\FieldTypes\Contracts\FieldTypeInterface;

abstract class BaseFieldType implements FieldTypeInterface
{
    protected function baseRules(bool $required): array
    {
        return $required ? ['required'] : ['nullable'];
    }
}
