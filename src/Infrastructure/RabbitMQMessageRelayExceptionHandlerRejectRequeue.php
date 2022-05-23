<?php

declare(strict_types=1);

namespace App\Infrastructure;

use OldSound\RabbitMqBundle\RabbitMq\ConsumerInterface;
use Throwable;

class RabbitMQMessageRelayExceptionHandlerRejectRequeue implements RabbitMQMessageRelayExceptionHandler
{
    public function handleException(Throwable $throwable): int|bool
    {
        return ConsumerInterface::MSG_REJECT_REQUEUE;
    }
}
