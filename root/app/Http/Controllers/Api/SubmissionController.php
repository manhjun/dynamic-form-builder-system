<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FormResource;
use App\Http\Resources\SubmissionResource;
use App\Services\Contracts\FormServiceInterface;
use App\Services\Contracts\SubmissionServiceInterface;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function __construct(
        protected SubmissionServiceInterface $submissionService,
        protected FormServiceInterface $formService,
    ) {}

    public function activeForms()
    {
        $forms = $this->formService->getActiveForms();

        return FormResource::collection($forms);
    }

    public function submit(Request $request, int $formId)
    {
        $submission = $this->submissionService->submit($formId, $request->all());

        return new SubmissionResource($submission);
    }

    public function index()
    {
        $submissions = $this->submissionService->getAllSubmissions();

        return SubmissionResource::collection($submissions);
    }
}
