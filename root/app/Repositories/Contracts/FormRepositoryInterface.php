<?php

namespace App\Repositories\Contracts;

interface FormRepositoryInterface
{
    public function getAllForms();
    public function getActiveForms();
    public function getFormById(int $id);
    public function createForm(array $data);
    public function updateForm(int $id, array $data);
    public function deleteForm(int $id);
}
