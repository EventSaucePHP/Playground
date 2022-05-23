<?php

declare(strict_types=1);

namespace App\Infrastructure;

use Throwable;

interface RabbitMQMessageRelayExceptionHandler
{
    public function handleException(Throwable $throwable): int|bool;
}
