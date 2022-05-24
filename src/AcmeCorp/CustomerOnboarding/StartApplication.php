<?php

declare(strict_types=1);

namespace App\AcmeCorp\CustomerOnboarding;

class StartApplication implements CustomerOnboardingCommand
{
    public function __construct(
        private CustomerOnboardingId $onboardingId
    ) {
    }

    public function onboardingId(): CustomerOnboardingId
    {
        return $this->onboardingId;
    }
}
