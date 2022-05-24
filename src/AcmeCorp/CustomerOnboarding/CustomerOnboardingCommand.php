<?php

declare(strict_types=1);

namespace App\AcmeCorp\CustomerOnboarding;

interface CustomerOnboardingCommand
{
    public function onboardingId(): CustomerOnboardingId;
}
