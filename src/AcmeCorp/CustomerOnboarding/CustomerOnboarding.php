<?php

declare(strict_types=1);

namespace App\AcmeCorp\CustomerOnboarding;

use App\AcmeCorp\CustomerOnboarding\VettingPersonalInformation\PersonalInformationVetting;
use DateTimeImmutable;
use EventSauce\Clock\Clock;
use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour;
use EventSauce\EventSourcing\AggregateRootId;
use Generator;

class CustomerOnboarding implements AggregateRoot
{
    use AggregateRootBehaviour;

    public function startApplication(Clock $clock): void
    {
        $this->recordThat(new ApplicationWasStarted($clock->now()));
    }

    protected function applyApplicationWasStarted(ApplicationWasStarted $event)
    {
        // ignore this for now
    }

    public function recordPersonalInformation(
        PersonalInformation $personalInformation,
        PersonalInformationVetting $informationVetting,
    ) {
        $this->guardAgainstInvalidDateOfBirth($personalInformation->dateOfBirth);
        $this->guardAgainstInvalidPersonalInformation($personalInformation, $informationVetting);

        $this->recordThat(
            new PersonalInformationWasRecorded(
                $personalInformation->firstName,
                $personalInformation->lastName,
                $personalInformation->email,
                $personalInformation->dateOfBirth,
            )
        );
    }

    protected function applyPersonalInformationWasRecorded(PersonalInformationWasRecorded $event)
    {
        // ignore this for now
    }

    private function guardAgainstInvalidDateOfBirth(string $dateOfBirth): void
    {
        $parsedDate = DateTimeImmutable::createFromFormat('d-m-Y', $dateOfBirth);

        if ($parsedDate === false || $dateOfBirth !== $parsedDate->format('d-m-Y')) {
            throw InvalidDateOfBirthProvided::fromInput($dateOfBirth);
        }
    }

    private function guardAgainstInvalidPersonalInformation(
        PersonalInformation $personalInformation,
        PersonalInformationVetting $informationVetting
    ) {
        if ( ! $informationVetting->isAllowed($personalInformation)) {
            throw new InvalidPersonalInformationWasProvided();
        }
    }
}
