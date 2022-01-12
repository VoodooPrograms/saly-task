<?php

namespace App\Services\Validator;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidatorService implements ValidatorServiceInterface
{
    protected ValidatorInterface $validator;

    public function __construct(ValidatorInterface $validator)
    {
        $this->validator = $validator;
    }

    public function validate(Request $request, string $dtoClassName)
    {
        if ($request->getContentType() === 'json') {
            $playlistDTO = new $dtoClassName(json_decode($request->getContent(), true));
        } else {
            $playlistDTO = new $dtoClassName(array_merge(
                $request->request->all(),
                $request->files->all(),
            ));
        }

        $errors = $this->validator->validate($playlistDTO);

        if (count($errors) > 0) {
            foreach($errors as $violation) {
                $violations[$violation->getPropertyPath()][] = $violation->getMessage();
            }

            return new Response(json_encode($violations, true));
        }
        return $playlistDTO;
    }
}