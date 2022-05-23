<?php

declare(strict_types=1);

namespace App\AcmeCorp;

use EventSauce\EventSourcing\EventDispatcher;

class AcmeService
{
    public function __construct(private EventDispatcher $dispatcher)
    {
    }

    public function recordSomethingHappened(int $number): void
    {
        $this->dispatcher->dispatch(new SomethingHappened($number));
    }
}
