<?php

declare(strict_types=1);

namespace App\AcmeCorp\CustomerOnboarding\VettingPersonalInformation;

use App\AcmeCorp\CustomerOnboarding\PersonalInformation;

use function in_array;

class SanctionListPersonalInformationVetting implements PersonalInformationVetting
{
    private array $disallowedPersonalInformation = [];

    public function __construct()
    {
        $this->disallowedPersonalInformation = [
            new PersonalInformation('Frank', 'de Jonge', 'info@frankdejonge.nl', '24-11-1988'),
        ];
    }

    public function isAllowed(PersonalInformation $personalInformation): bool
    {
        return ! in_array($personalInformation, $this->disallowedPersonalInformation, strict: false);
    }
}
