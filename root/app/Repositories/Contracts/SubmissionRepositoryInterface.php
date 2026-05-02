<?php

namespace App\Repositories\Contracts;

interface SubmissionRepositoryInterface
{
    public function getAllSubmissions();
    public function createSubmission(int $formId, int $formVersionId): mixed;
    public function createSubmissionValues(int $submissionId, array $values): void;
}
