<?php

namespace App\Repositories\Eloquent;

use App\Models\Submission;
use App\Models\SubmissionValue;
use App\Repositories\Contracts\SubmissionRepositoryInterface;
use Prettus\Repository\Eloquent\BaseRepository;

class SubmissionRepository extends BaseRepository implements SubmissionRepositoryInterface
{
    public function model(): string
    {
        return Submission::class;
    }

    public function getAllSubmissions()
    {
        return $this->model
            ->with(['form', 'formVersion', 'values.field'])
            ->latest()
            ->get();
    }

    public function createSubmission(int $formId, int $formVersionId): mixed
    {
        return $this->model->create([
            'form_id'         => $formId,
            'form_version_id' => $formVersionId,
        ]);
    }

    public function createSubmissionValues(int $submissionId, array $values): void
    {
        $records = array_map(fn($fieldId, $value) => [
            'submission_id' => $submissionId,
            'field_id'      => $fieldId,
            'value'         => json_encode($value),
            'created_at'    => now(),
            'updated_at'    => now(),
        ], array_keys($values), $values);

        SubmissionValue::insert($records);
    }
}
