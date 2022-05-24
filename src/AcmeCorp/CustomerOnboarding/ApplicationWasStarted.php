<?php

declare(strict_types=1);

namespace App\AcmeCorp\CustomerOnboarding;

use DateTimeImmutable;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

class ApplicationWasStarted implements SerializablePayload
{
    const DATETIME_FORMAT = 'Y-m-d H:i:s.uO';

    public function __construct(
        private DateTimeImmutable $applicationStartDate
    ) {
    }

    public function toPayload(): array
    {
        return [
            'application_start_date' => $this->applicationStartDate->format(self::DATETIME_FORMAT),
        ];
    }

    public static function fromPayload(array $payload): static
    {
        return new ApplicationWasStarted(
            DateTimeImmutable::createFromFormat(self::DATETIME_FORMAT, $payload['application_start_date']),
        );
    }

    public function onboardId(): CustomerOnboardingId
    {
    }
}
