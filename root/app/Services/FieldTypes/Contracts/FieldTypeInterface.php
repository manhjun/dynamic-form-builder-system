<?php

namespace App\Services\FieldTypes\Contracts;

interface FieldTypeInterface
{
    public function getType(): string;
    public function buildRules(array $validation, bool $required): array;
}
