<?php

namespace App\Services\Contracts;

interface ExamplesServiceInterface
{
    public function index();

    public function store($request);
}
