<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FieldResource;
use App\Services\Contracts\FieldServiceInterface;
use App\Http\Requests\StoreFieldRequest;
use App\Http\Requests\UpdateFieldRequest;

class FieldController extends Controller
{
    public function __construct(
        protected FieldServiceInterface $fieldService,
    ) {}

    public function store(StoreFieldRequest $request, int $formId)
    {
        $field = $this->fieldService->createField($formId, $request->validated());

        return new FieldResource($field);
    }

    public function update(UpdateFieldRequest $request, int $formId, int $fieldId)
    {
        $version = $this->fieldService->updateField($formId, $fieldId, $request->validated());

        return FieldResource::collection($version->fields);
    }

    public function destroy(int $formId, int $fieldId)
    {
        $this->fieldService->deleteField($fieldId);

        return response()->json(['message' => 'Field deleted successfully.']);
    }
}
