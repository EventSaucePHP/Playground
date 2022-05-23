<?php

declare(strict_types=1);

namespace App\Infrastructure;

use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageDispatcher;
use EventSauce\EventSourcing\Serialization\MessageSerializer;
use EventSauce\EventSourcing\UnableToDispatchMessages;
use OldSound\RabbitMqBundle\RabbitMq\ProducerInterface;
use Throwable;

use function json_encode;

class RabbitMQMessageDispatcher implements MessageDispatcher
{
    public function __construct(
        private ProducerInterface $producer,
        private MessageSerializer $messageSerializer,
    )
    {
    }

    public function dispatch(Message ...$messages): void
    {
        try {
            foreach ($messages as $message) {
                $payload = $this->messageSerializer->serializeMessage($message);
                $this->producer->publish(json_encode($payload));
            }
        } catch (Throwable $exception) {
            throw UnableToDispatchMessages::dueTo($exception->getMessage(), $exception);
        }
    }
}
