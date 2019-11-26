<?php

declare(strict_types=1);

namespace App\Appointment\Domain\Model\Patient;

use App\Appointment\Domain\Event\PatientNameChanged;
use App\Appointment\Domain\Event\PatientWasCreated;
use App\Shared\EntityInterface;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;

final class Patient extends AggregateRoot implements EntityInterface
{
    /**
     * @var PatientId|null
     */
    private $patientId;

    /**
     * @var Name|null
     */
    private $name;

    /**
     * @var Birth|null
     */
    private $birth;

    /**
     * @return PatientId|null
     */
    public function getPatientId(): ?PatientId
    {
        return $this->patientId;
    }

    /**
     * @return Name|null
     */
    public function getName(): ?Name
    {
        return $this->name;
    }

    /**
     * @return Birth|null
     */
    public function getBirth(): ?Birth
    {
        return $this->birth;
    }

    public static function create(
        PatientId $patientId,
        Name $name,
        Birth $birth
    ): self
    {
        $self = new self();
        $self->recordThat(PatientWasCreated::withData($patientId, $name, $birth));

        return $self;
    }

    public function changeName(Name $name): void
    {
        $this->name = $name;
        
        $this->recordThat(PatientNameChanged::withData($this->patientId, $name));
    }

    public function sameIdentityAs(EntityInterface $other): bool
    {
        // TODO: Implement sameIdentityAs() method.
    }

    /**
     * @return string
     */
    protected function aggregateId(): string
    {
        return $this->patientId->toString();
    }

    /**
     * Apply given event
     *
     * @param AggregateChanged $event
     */
    protected function apply(AggregateChanged $event): void
    {
        switch (get_class($event)) {
            case PatientWasCreated::class:
                assert($event instanceof PatientWasCreated);
                $this->patientId = $event->patientId();
                $this->name = $event->name();
                $this->birth = $event->birth();
                break;
            case PatientNameChanged::class:
                assert($event instanceof PatientNameChanged);
                $this->name = $event->name();
                break;
        }
    }
}