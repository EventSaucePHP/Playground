<?php

declare(strict_types=1);

namespace App\AcmeCorp\CustomerOnboarding;

class RecordPersonalInformation implements CustomerOnboardingCommand
{
    public function __construct(
        private CustomerOnboardingId $onboardingId,
        private readonly string $firstName,
        private readonly string $lastName,
        private readonly string $email,
        private readonly string $dateOfBirth
    ) {
    }

    public function personalInformation(): PersonalInformation
    {
        return new PersonalInformation($this->firstName, $this->lastName, $this->email, $this->dateOfBirth);
    }

    public function onboardingId(): CustomerOnboardingId
    {
        return $this->onboardingId;
    }
}
