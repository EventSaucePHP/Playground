<?php

declare(strict_types=1);

namespace App\AcmeCorp\CustomerOnboarding;

use EventSauce\EventSourcing\AggregateRootId;
use Ramsey\Uuid\Uuid;

class CustomerOnboardingId implements AggregateRootId
{
    private function __construct(
        private string $id
    )
    {
    }

    public function toString(): string
    {
        return $this->id;
    }

    public static function generate(): CustomerOnboardingId
    {
        return new CustomerOnboardingId(Uuid::uuid4()->toString());
    }

    public static function fromString(string $aggregateRootId): static
    {
        return new static($aggregateRootId);
    }
}
