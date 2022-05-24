<?php

declare(strict_types=1);

namespace App\AcmeCorp\CustomerOnboarding\VettingPersonalInformation;

class SanctionListPersonalInformationVettingTest extends PersonalInformationVettingTestCase
{
    protected function informationVetting(): PersonalInformationVetting
    {
        return new SanctionListPersonalInformationVetting();
    }
}
