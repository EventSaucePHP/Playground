<?php

declare(strict_types=1);

namespace App\AcmeCorp\CustomerOnboarding\VettingPersonalInformation;

use App\AcmeCorp\CustomerOnboarding\PersonalInformation;

interface PersonalInformationVetting
{
    public function isAllowed(PersonalInformation $personalInformation): bool;
}
