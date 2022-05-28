<?php

declare(strict_types=1);

namespace App\AcmeCorp\CustomerOnboarding;

class PersonalInformationWasRecorded
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $email,
        public readonly string $dateOfBirth,
    ) {
    }
}
