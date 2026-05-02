<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\FormDetailResource;
use App\Http\Resources\FormResource;
use App\Services\Contracts\FormServiceInterface;
use App\Http\Requests\StoreFormRequest;
use App\Http\Requests\UpdateFormRequest;

class FormController extends Controller
{
    public function __construct(
        protected FormServiceInterface $formService,
    ) {}

    public function index()
    {
        $forms = $this->formService->getAllForms();

        return FormResource::collection($forms);
    }

    public function show(int $id)
    {
        $form = $this->formService->getFormById($id);

        return new FormDetailResource($form);
    }

    public function store(StoreFormRequest $request)
    {
        $form = $this->formService->createForm($request->validated());

        return new FormResource($form);
    }

    public function update(UpdateFormRequest $request, int $id)
    {
        $form = $this->formService->updateForm($id, $request->validated());

        return new FormResource($form);
    }

    public function destroy(int $id)
    {
        $this->formService->deleteForm($id);

        return response()->json(['message' => 'Form deleted successfully.']);
    }
}
