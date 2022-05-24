<?php

declare(strict_types=1);

namespace App\AcmeCorp\CustomerOnboarding\VettingPersonalInformation;

use App\AcmeCorp\CustomerOnboarding\PersonalInformation;

class InMemoryPersonalInformationVettingTest extends PersonalInformationVettingTestCase
{
    protected function informationVetting(): PersonalInformationVetting
    {
        $vetter = new InMemoryPersonalInformationVetting();
        $vetter->disallowInformation(new PersonalInformation('Frank', 'de Jonge', 'info@frankdejonge.nl', '24-11-1988'));

        return $vetter;
    }
}
