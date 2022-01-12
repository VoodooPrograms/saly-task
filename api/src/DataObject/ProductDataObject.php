<?php

namespace App\DataObject;

use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Positive;

class ProductDataObject extends DataObject
{
    #[NotBlank]
    #[Length(
        min: 3, minMessage: 'Name of Product must be at least {{ limit }} characters long',
        max: 255, maxMessage: 'Name of Product must be no longer than {{ limit }} characters',
    )]
    public string $name;

    #[NotBlank]
    #[Positive]
    public string $price;
}