<?php

declare(strict_types=1);

namespace App\Console;


use App\AcmeCorp\AcmeService;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\SignalableCommandInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function pcntl_signal_dispatch;
use function time;
use function usleep;

class ProduceNumbersCommand extends Command implements SignalableCommandInterface
{
    private bool $shouldContinue = true;

    public function __construct(private AcmeService $acme)
    {
        parent::__construct(null);
    }

    protected function configure()
    {
        $this->setName('acme:produce-numbers');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $number = time();

        while($this->shouldContinue) {
            $output->writeln('Dispatching ' . $number);
            $this->acme->recordSomethingHappened($number);
            $number++;
            pcntl_signal_dispatch();
            usleep(100000);
        }

        return 0;
    }

    public function getSubscribedSignals(): array
    {
        return [\SIGINT, \SIGTERM];
    }

    public function handleSignal(int $signal): void
    {
        $this->shouldContinue = false;
    }
}
