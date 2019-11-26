<?php

declare(strict_types=1);

namespace App\Appointment\Domain\Event;

use App\Appointment\Domain\Model\Appointment\AppointmentId;
use App\Appointment\Domain\Model\Appointment\Description;
use App\Appointment\Domain\Model\Appointment\Title;
use Prooph\EventSourcing\AggregateChanged;

final class AppointmentWasCreated extends AggregateChanged
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

    public function appointmentId(): AppointmentId
    {
        if (null === $this->appointmentId) {
            $this->appointmentId = AppointmentId::fromString($this->aggregateId());
        }

        return $this->appointmentId;
    }

    public function title(): Title
    {
        return Title::fromString($this->payload['title']);
    }

    public function description(): Description
    {
        return Description::fromString($this->payload['description']);
    }

    public static function withData(AppointmentId $appointmentId, Title $title, Description $description): self
    {
        $event = self::occur($appointmentId->toString(), [
            'title' => $title->toString(),
            'description' => $description->toString()
        ]);

        $event->title = $title;
        $event->description = $description;

        return $event;
    }
}
