<?php

namespace App\Services\Api;

use App\Exceptions\FormNotActiveException;
use App\Repositories\Contracts\FormVersionRepositoryInterface;
use App\Repositories\Contracts\SubmissionRepositoryInterface;
use App\Services\Contracts\SubmissionServiceInterface;
use App\Services\Validators\FormValidator;
use Illuminate\Support\Facades\DB;

class SubmissionService implements SubmissionServiceInterface
{
    public function __construct(
        protected SubmissionRepositoryInterface $submissionRepository,
        protected FormVersionRepositoryInterface $formVersionRepository,
        protected FormValidator $formValidator,
    ) {}

    public function getAllSubmissions()
    {
        return $this->submissionRepository->getAllSubmissions();
    }

    public function submit(int $formId, array $values)
    {
        $version = $this->formVersionRepository->getActiveVersion($formId);

        if (!$version) {
            throw new FormNotActiveException();
        }

        $this->formValidator->validate($version->fields, $values);

        return DB::transaction(function () use ($formId, $version, $values) {
            $submission = $this->submissionRepository->createSubmission($formId, $version->id);

            // Map field name -> field_id
            $mappedValues = [];
            foreach ($version->fields as $field) {
                if (array_key_exists($field->name, $values)) {
                    $mappedValues[$field->id] = $values[$field->name];
                }
            }

            $this->submissionRepository->createSubmissionValues($submission->id, $mappedValues);

            return $submission->load('values.field');
        });
    }
}
