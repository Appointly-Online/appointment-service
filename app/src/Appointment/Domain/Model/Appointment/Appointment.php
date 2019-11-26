<?php

declare(strict_types=1);

namespace App\Appointment\Domain\Model\Appointment;

use App\Appointment\Domain\Event\AppointmentDescriptionChanged;
use App\Appointment\Domain\Event\AppointmentWasCreated;
use App\Appointment\Domain\Exception\SameDescriptionException;
use App\Shared\EntityInterface;
use Prooph\EventSourcing\AggregateChanged;
use Prooph\EventSourcing\AggregateRoot;

final class Appointment extends AggregateRoot implements EntityInterface
{
    /**
     * @var AppointmentId|null
     */
    private $appointmentId;

    /**
     * @var Title|null
     */
    private $title;

    /**
     * @var Description|null
     */
    private $description;

    /**
     * @return AppointmentId|null
     */
    public function appointmentId(): ?AppointmentId
    {
        return $this->appointmentId;
    }

    /**
     * @return Title|null
     */
    public function title(): ?Title
    {
        return $this->title;
    }

    /**
     * @return Description|null
     */
    public function description(): ?Description
    {
        return $this->description;
    }

    public static function register(
        AppointmentId $appointmentId,
        Title $title,
        Description $description
    ): self {
        $self = new self();

        $self->recordThat(AppointmentWasCreated::withData(
            $appointmentId,
            $title,
            $description
        ));

        return $self;
    }

    public function changeDescription(Description $description): void
    {
        if ($this->description->toString() === $description->toString()) {
            throw new SameDescriptionException();
        }
        
        $this->recordThat(AppointmentDescriptionChanged::withData($this->appointmentId, $description));
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
        return $this->appointmentId->toString();
    }

    /**
     * Apply given event
     *
     * @param AggregateChanged $event
     */
    protected function apply(AggregateChanged $event): void
    {
        switch (get_class($event)) {
            case AppointmentWasCreated::class:
                assert($event instanceof AppointmentWasCreated);
                $this->appointmentId = $event->appointmentId();
                $this->title = $event->title();
                $this->description = $event->description();
            break;
            case AppointmentDescriptionChanged::class:
                assert($event instanceof AppointmentDescriptionChanged);
                $this->description = $event->description();
                break;
        }
    }
}
