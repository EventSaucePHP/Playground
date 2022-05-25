<?php

declare(strict_types=1);

namespace App\AcmeCorp\CustomerOnboarding;

use App\AcmeCorp\CustomerOnboarding\VettingPersonalInformation\InMemoryPersonalInformationVetting;
use EventSauce\EventSourcing\AggregateRootId;
use EventSauce\EventSourcing\TestUtilities\AggregateRootTestCase;

class CustomerOnboardingTest extends AggregateRootTestCase
{
    private InMemoryPersonalInformationVetting $personalInformationVetting;

    protected function newAggregateRootId(): AggregateRootId
    {
        return CustomerOnboardingId::generate();
    }

    protected function aggregateRootClassName(): string
    {
        return CustomerOnboarding::class;
    }

    /**
     * @before
     */
    public function setupPersonalInformation(): void
    {
        $this->personalInformationVetting = new InMemoryPersonalInformationVetting();
    }

    protected function handle(CustomerOnboardingCommand $command)
    {
        $service = new CustomerOnboardingService(
            $this->clock(),
            $this->repository,
            $this->personalInformationVetting,
        );

        $service->handle($command);
    }

    /**
     * @test
     */
    public function starting_an_application(): void
    {
        $this->when(new StartApplication($this->aggregateRootId()))
            ->then(
                new ApplicationWasStarted($this->currentTime()),
            );
    }

    /**
     * @test
     */
    public function supplying_personal_information(): void
    {
        $this->given(new ApplicationWasStarted($this->currentTime()))
            ->when(new RecordPersonalInformation(
                $this->aggregateRootId(),
                'Frank',
                'de Jonge',
                'info@frankdejonge.nl',
                '24-11-1987',
            ))
            ->then(new PersonalInformationWasRecorded(
                'Frank',
                'de Jonge',
                'info@frankdejonge.nl',
                '24-11-1987',
            ));
    }

    /**
     * @test
     */
    public function invalid_personal_information_is_rejected(): void
    {
        $this->personalInformationVetting->disallowInformation(new PersonalInformation(
            'Frank',
            'de Jonge',
            'info@frankdejonge.nl',
            '24-11-1960',
        ));

        $this->given(new ApplicationWasStarted($this->currentTime()))
            ->when(new RecordPersonalInformation(
                       $this->aggregateRootId(),
                       'Frank',
                       'de Jonge',
                       'info@frankdejonge.nl',
                       '24-11-1960',
                   ))
            ->expectToFail(new InvalidPersonalInformationWasProvided());
    }

    /**
     * @test
     */
    public function trying_to_supply_an_invalid_date_of_birth(): void
    {
        $this->given(new ApplicationWasStarted($this->currentTime()))
            ->when(new RecordPersonalInformation(
                       $this->aggregateRootId(),
                       'Frank',
                       'de Jonge',
                       'info@frankdejonge.nl',
                       '240-11-1987',
                   ))
            ->expectToFail(InvalidDateOfBirthProvided::fromInput('240-11-1987'));
    }
}
