<?php

namespace App\Http\Requests;

use App\Services\FieldTypes\FieldTypeRegistry;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFieldRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $registry = app(FieldTypeRegistry::class);

        return [
            'name'        => 'required|string|max:255',
            'label'       => 'required|string|max:255',
            'type'        => ['required', 'string', Rule::in($registry->all())],
            'required'    => 'boolean',
            'sort_order'  => 'nullable|integer|min:0',
            'placeholder' => 'nullable|string',
            'help_text'   => 'nullable|string',
            'options'     => 'nullable|array',
            'options.*'   => 'required|string',
            'validation'  => 'nullable|array',
        ];
    }
}
