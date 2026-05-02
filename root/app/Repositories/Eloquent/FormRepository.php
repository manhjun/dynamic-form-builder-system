<?php

namespace App\Repositories\Eloquent;

use App\Models\Form;
use App\Repositories\Contracts\FormRepositoryInterface;
use Prettus\Repository\Eloquent\BaseRepository;

class FormRepository extends BaseRepository implements FormRepositoryInterface
{
    public function model(): string
    {
        return Form::class;
    }

    public function getAllForms()
    {
        return $this->model->orderBy('order')->get();
    }

    public function getActiveForms()
    {
        return $this->model
            ->whereHas('versions', fn($q) => $q->where('status', 'active'))
            ->orderBy('order')
            ->get();
    }

    public function getFormById(int $id)
    {
        return $this->model->with(['versions' => function ($q) {
            $q->where('status', 'active');
        }, 'versions.fields'])->findOrFail($id);
    }

    public function createForm(array $data)
    {
        return $this->model->create($data);
    }

    public function updateForm(int $id, array $data)
    {
        $form = $this->model->findOrFail($id);
        $form->update($data);
        return $form;
    }

    public function deleteForm(int $id)
    {
        return $this->model->findOrFail($id)->delete();
    }
}
