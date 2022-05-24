<?php

declare(strict_types=1);

namespace App\AcmeCorp\CustomerOnboarding\VettingPersonalInformation;

use App\AcmeCorp\CustomerOnboarding\PersonalInformation;
use PHPUnit\Framework\TestCase;

abstract class PersonalInformationVettingTestCase extends TestCase
{
    abstract protected function informationVetting(): PersonalInformationVetting;

    /**
     * @test
     */
    public function it_allows_valid_personal_information(): void
    {
        $vetting = $this->informationVetting();
        $validPersonalInformation = new PersonalInformation('Frank', 'de Jonge', 'info@frankdejonge.nl', '24-11-1987');

        $result = $vetting->isAllowed($validPersonalInformation);

        self::assertTrue($result);
    }

    /**
     * @test
     */
    public function it_does_not_allow_invalid_personal_information(): void
    {
        $vetting = $this->informationVetting();
        $validPersonalInformation = new PersonalInformation('Frank', 'de Jonge', 'info@frankdejonge.nl', '24-11-1988');

        $result = $vetting->isAllowed($validPersonalInformation);

        self::assertFalse($result);
    }
}
