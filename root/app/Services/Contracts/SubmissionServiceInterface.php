<?php

namespace App\Services\Contracts;

interface SubmissionServiceInterface
{
    public function getAllSubmissions();
    public function submit(int $formId, array $values);
}
