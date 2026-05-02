<?php

namespace App\Exceptions;

class FormNotActiveException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Form is not active.', 422);
    }
}
