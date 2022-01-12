<?php

namespace App\Services\Validator;

use Symfony\Component\HttpFoundation\Request;

interface ValidatorServiceInterface
{
    public function validate(Request $request, string $dtoClassName);
}