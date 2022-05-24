<?php

declare(strict_types=1);

namespace App\AcmeCorp\CustomerOnboarding;

class PersonalInformation
{
    public readonly string $firstName;
    public readonly string $lastName;
    public readonly string $email;
    public readonly string $dateOfBirth;

    public function __construct(string $firstName, string $lastName, string $email, string $dateOfBirth)
    {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->dateOfBirth = $dateOfBirth;
    }
}
