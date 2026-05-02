<?php

namespace App\Services\Api;

use App\Repositories\Contracts\FormRepositoryInterface;
use App\Repositories\Contracts\FormVersionRepositoryInterface;
use App\Services\Contracts\FormServiceInterface;
use Illuminate\Support\Facades\DB;

class FormService implements FormServiceInterface
{
    public function __construct(
        protected FormRepositoryInterface $formRepository,
        protected FormVersionRepositoryInterface $formVersionRepository,
    ) {}

    public function getAllForms()
    {
        return $this->formRepository->getAllForms();
    }

    public function getActiveForms()
    {
        return $this->formRepository->getActiveForms();
    }

    public function getFormById(int $id)
    {
        return $this->formRepository->getFormById($id);
    }

    public function createForm(array $data)
    {
        return DB::transaction(function () use ($data) {
            $form = $this->formRepository->createForm([
                'title'       => $data['title'],
                'description' => $data['description'] ?? null,
                'order'       => $data['order'] ?? 0,
            ]);

            // Create initial version for the form
            $this->formVersionRepository->createVersion($form->id, [
                'status' => 'draft',
            ]);

            return $form;
        });
    }

    public function updateForm(int $id, array $data)
    {
        return DB::transaction(function () use ($id, $data) {
            $form = $this->formRepository->updateForm($id, array_filter([
                'title'       => $data['title'] ?? null,
                'description' => $data['description'] ?? null,
                'order'       => $data['order'] ?? null,
            ]));

            if (isset($data['status'])) {
                $this->formVersionRepository->activateVersion($id, $data['status']);
            }

            return $form;
        });
    }

    public function deleteForm(int $id)
    {
        return $this->formRepository->deleteForm($id);
    }
}
