<?php

namespace App\Exceptions;

class FormVersionException extends \Exception
{
    public function __construct(string $message = 'Form version error.')
    {
        parent::__construct($message, 422);
    }
}
