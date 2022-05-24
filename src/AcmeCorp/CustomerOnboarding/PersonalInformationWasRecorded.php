<?php

declare(strict_types=1);

namespace App\AcmeCorp\CustomerOnboarding;

use EventSauce\EventSourcing\Serialization\SerializablePayload;

class PersonalInformationWasRecorded implements SerializablePayload
{
    public function __construct(
        public readonly string $firstName,
        public readonly string $lastName,
        public readonly string $email,
        public readonly string $dateOfBirth,
    ) {
    }

    public function toPayload(): array
    {
        return [
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'email' => $this->email,
            'date_of_birth' => $this->dateOfBirth,
        ];
    }

    public static function fromPayload(array $payload): static
    {
        return new static(
            $payload['first_name'],
            $payload['last_name'],
            $payload['email'],
            $payload['date_of_birth'],
        );
    }
}
