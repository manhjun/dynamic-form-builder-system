<?php

namespace App\Repositories\Eloquent;

use App\Models\Field;
use App\Repositories\Contracts\FieldRepositoryInterface;
use Prettus\Repository\Eloquent\BaseRepository;

class FieldRepository extends BaseRepository implements FieldRepositoryInterface
{
    public function model(): string
    {
        return Field::class;
    }

    public function findField(int $fieldId): Field
    {
        return $this->find($fieldId);
    }

    public function getFieldsByVersion(int $formVersionId)
    {
        return $this->model
            ->where('form_version_id', $formVersionId)
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();
    }

    public function createField(int $formVersionId, array $data): Field
    {
        return $this->model->create([
            'form_version_id' => $formVersionId,
            ...$data,
        ]);
    }

    public function updateField(int $fieldId, array $data): Field
    {
        $field = $this->model->findOrFail($fieldId);
        $field->update($data);
        return $field;
    }

    public function deleteField(int $fieldId): bool
    {
        return $this->model->findOrFail($fieldId)->delete();
    }
}
