<?php

declare(strict_types=1);

namespace App\AcmeCorp\CustomerOnboarding;

use App\AcmeCorp\CustomerOnboarding\VettingPersonalInformation\PersonalInformationVetting;
use EventSauce\Clock\Clock;
use EventSauce\EventSourcing\AggregateRootRepository;

class CustomerOnboardingService
{
    public function __construct(
        private Clock $clock,
        private AggregateRootRepository $repository,
        private PersonalInformationVetting $informationVetting,
    ) {
    }

    public function handle(CustomerOnboardingCommand $command): void
    {
        /** @var CustomerOnboarding $onboardingProcess */
        $onboardingProcess = $this->repository->retrieve($command->onboardingId());

        try {
            match (get_class($command)) {
                StartApplication::class => $onboardingProcess->startApplication($this->clock),
                RecordPersonalInformation::class => $onboardingProcess->recordPersonalInformation(
                    $command->personalInformation(),
                    $this->informationVetting,
                ),
            };
        } finally {
            $this->repository->persist($onboardingProcess);
        }
    }
}
