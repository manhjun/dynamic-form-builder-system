<?php

namespace App\Services\Api;

use App\Repositories\Contracts\FieldRepositoryInterface;
use App\Repositories\Contracts\FormVersionRepositoryInterface;
use App\Services\Contracts\FieldServiceInterface;
use Illuminate\Support\Facades\DB;

class FieldService implements FieldServiceInterface
{
    public function __construct(
        protected FieldRepositoryInterface $fieldRepository,
        protected FormVersionRepositoryInterface $formVersionRepository,
    ) {}

    public function createField(int $formId, array $data)
    {
        $version = $this->formVersionRepository->getActiveVersion($formId)
            ?? $this->formVersionRepository->createVersion($formId, ['status' => 'draft']);

        return $this->fieldRepository->createField($version->id, $data);
    }

    public function updateField(int $formId, int $fieldId, array $data)
    {
        return DB::transaction(function () use ($formId, $fieldId, $data) {
            // Get active version instead of oldField's version
            $activeVersion = $this->formVersionRepository->getActiveVersion($formId);

            if (!$activeVersion) {
                throw new \InvalidArgumentException('No active version found.');
            }

            $newVersion = $this->formVersionRepository->createVersion($formId, [
                'status' => 'draft',
            ]);

            // Copy from active version, not from specific field's version
            $existingFields = $this->fieldRepository->getFieldsByVersion($activeVersion->id);

            foreach ($existingFields as $field) {
                $fieldData = $field->toArray();
                unset($fieldData['id'], $fieldData['created_at'], $fieldData['updated_at'], $fieldData['form_version_id']);

                if ($field->id === $fieldId) {
                    $fieldData = array_merge($fieldData, $data);
                }

                $this->fieldRepository->createField($newVersion->id, $fieldData);
            }

            return $newVersion->load('fields');
        });
    }

    public function deleteField(int $fieldId)
    {
        return $this->fieldRepository->deleteField($fieldId);
    }
}
