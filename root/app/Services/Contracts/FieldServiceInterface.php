<?php

namespace App\Services\Contracts;

interface FieldServiceInterface
{
    public function createField(int $formId, array $data);
    public function updateField(int $formId, int $fieldId, array $data);
    public function deleteField(int $fieldId);
}
