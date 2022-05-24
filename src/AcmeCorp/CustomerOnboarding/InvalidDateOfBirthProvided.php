<?php

declare(strict_types=1);

namespace App\AcmeCorp\CustomerOnboarding;

use RuntimeException;

class InvalidDateOfBirthProvided extends RuntimeException
{
    private readonly string $input;

    private function __construct(string $message, string $input)
    {
        parent::__construct($message);
        $this->input = $input;
    }

    public function input(): string
    {
        return $this->input;
    }

    public static function fromInput(string $input): static
    {
        return new static('Invalid date of birth provided: ' . $input, $input);
    }
}
