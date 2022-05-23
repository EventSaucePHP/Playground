<?php

declare(strict_types=1);

namespace App\Infrastructure;

use EventSauce\EventSourcing\MessageConsumer;
use EventSauce\EventSourcing\Serialization\MessageSerializer;
use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use PhpAmqpLib\Message\AMQPMessage;

use Throwable;

use function json_decode;

use const JSON_THROW_ON_ERROR;

class RabbitMQMessageRelay implements ConsumerInterface
{
    public function __construct(
        private MessageConsumer $consumer,
        private MessageSerializer $serializer,
        private RabbitMQMessageRelayExceptionHandler $exceptionHandler,
    ) {
    }

    public function execute(AMQPMessage $msg): int|bool
    {
        try {
            $payload = json_decode($msg->getBody(), associative: true, flags: JSON_THROW_ON_ERROR);
            $message = $this->serializer->unserializePayload($payload);
            $this->consumer->handle($message);

            return ConsumerInterface::MSG_ACK;
        } catch (Throwable $throwable) {
            return $this->exceptionHandler->handleException($throwable);
        }
    }
}
