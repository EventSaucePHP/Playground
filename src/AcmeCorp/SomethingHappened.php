<?php

declare(strict_types=1);

namespace App\AcmeCorp;

use EventSauce\EventSourcing\Serialization\SerializablePayload;

class SomethingHappened implements SerializablePayload
{
    public function __construct(
        private int $number,
    )
    {
    }

    public function toPayload(): array
    {
        return ['number' => $this->number];
    }

    public static function fromPayload(array $payload): static
    {
        return new static($payload['number']);
    }

    public function number(): int
    {
        return $this->number;
    }
}
