<?php

declare(strict_types=1);

namespace App\Infrastructure;

use EventSauce\EventSourcing\Serialization\PayloadSerializer;
use EventSauce\ObjectHydrator\ObjectHydrator;
use EventSauce\ObjectHydrator\ObjectSerializer;

class ObjectHydratorloadSerialization implements PayloadSerializer
{
    public function __construct(
        private ObjectSerializer $serializer,
        private ObjectHydrator $hydrator,
    ) {
    }

    public function serializePayload(object $event): array
    {
        return $this->serializer->serializeObject($event);
    }

    public function unserializePayload(string $className, array $payload): object
    {
        return $this->hydrator->hydrateObject($className, $payload);
    }
}
