<?php

declare(strict_types=1);

namespace App\AcmeCorp;

use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageConsumer;
use Psr\Log\LoggerInterface;

use function fwrite;

use function usleep;

use const STDOUT;

class InterestedInSomethingHappening implements MessageConsumer
{
    public function __construct()
    {
    }

    public function handle(Message $message): void
    {
        $event = $message->payload();

        if ($event instanceof SomethingHappened) {
            fwrite(STDOUT, "'Something happened with the number {$event->number()}.\n");
            usleep(300000);
        }
    }
}
