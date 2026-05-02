<?php

namespace App\Services\Validators;

use App\Services\FieldTypes\FieldTypeRegistry;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class FormValidator
{
    public function __construct(
        protected FieldTypeRegistry $registry,
    ) {}

    public function validate($fields, array $values): void
    {
        $rules = [];

        foreach ($fields as $field) {
            $type = $this->registry->get($field->type);
            $rules[$field->name] = $type->buildRules(
                $field->validation ?? [],
                $field->required
            );
        }

        $validator = Validator::make($values, $rules);

        if ($validator->fails()) {
            throw new ValidationException($validator);
        }
    }
}
