<?php

declare(strict_types=1);

namespace App\Infrastructure;

use EventSauce\EventSourcing\EventDispatcher;
use EventSauce\EventSourcing\MessageConsumer;
use EventSauce\EventSourcing\MessageDispatchingEventDispatcher;
use EventSauce\EventSourcing\Serialization\MessageSerializer;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;

class RabbitMQServiceFactory
{
    public function __construct(private MessageSerializer $serializer)
    {
    }

    public function messageRelay(
        MessageConsumer $consumer,
        ?MessageSerializer $serializer = null,
        ?RabbitMQMessageRelayExceptionHandler $exceptionHandler = null,
    ): RabbitMQMessageRelay {
        return new RabbitMQMessageRelay(
            $consumer,
            $serializer ?? $this->serializer,
            $exceptionHandler ?? new RabbitMQMessageRelayExceptionHandlerRejectRequeue()
        );
    }

    public function messageDispatcher(
        ProducerInterface $producer,
        ?MessageSerializer $serializer = null,
    ): RabbitMQMessageDispatcher {
        return new RabbitMQMessageDispatcher(
            $producer,
            $serializer ?? $this->serializer,
        );
    }

    public function eventDispatcher(
        ProducerInterface $producer,
        ?MessageSerializer $serializer = null,
    ): EventDispatcher {
        return new MessageDispatchingEventDispatcher(
            $this->messageDispatcher($producer, $serializer)
        );
    }
}
