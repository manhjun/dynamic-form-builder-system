<?php

namespace App\Repositories\Contracts;

use App\Models\Field;

interface FieldRepositoryInterface
{
    public function findField(int $fieldId): Field;
    public function getFieldsByVersion(int $formVersionId);
    public function createField(int $formVersionId, array $data);
    public function updateField(int $fieldId, array $data);
    public function deleteField(int $fieldId);
}
