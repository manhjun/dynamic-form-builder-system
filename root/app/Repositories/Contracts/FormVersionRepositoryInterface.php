<?php

namespace App\Repositories\Contracts;

interface FormVersionRepositoryInterface
{
    public function getActiveVersion(int $formId);
    public function createVersion(int $formId, array $data);
    public function activateVersion(int $formId, string $status): void;
}
