<?php

namespace App\Discount\Validator;

use App\Discount\Dto\Input\OrderInput;
use App\Discount\Exception\InvalidInputException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class OrderInputValidator
{
    public function __construct(
        private readonly ValidatorInterface $validator
    ) {
    }

    public function validate(OrderInput $input): void
    {
        $violations = $this->validator->validate($input);

        if ($violations->count() > 0) {
            throw new InvalidInputException($violations);
        }
    }
}
