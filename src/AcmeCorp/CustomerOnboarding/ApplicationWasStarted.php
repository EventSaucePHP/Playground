<?php

declare(strict_types=1);

namespace App\AcmeCorp\CustomerOnboarding;

use DateTimeImmutable;

class ApplicationWasStarted
{
    public function __construct(
        private DateTimeImmutable $applicationStartDate
    ) {
    }

    public function applicationStartDate(): DateTimeImmutable
    {
        return $this->applicationStartDate;
    }
}
