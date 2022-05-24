<?php

declare(strict_types=1);

namespace App\AcmeCorp\CustomerOnboarding\VettingPersonalInformation;

use App\AcmeCorp\CustomerOnboarding\PersonalInformation;

use function in_array;

class InMemoryPersonalInformationVetting implements PersonalInformationVetting
{
    private array $invalidInformation = [];

    public function disallowInformation(PersonalInformation $personalInformation): void
    {
        $this->invalidInformation[] = $personalInformation;
    }

    public function isAllowed(PersonalInformation $personalInformation): bool
    {
        return ! in_array($personalInformation, $this->invalidInformation, strict: false);
    }
}
