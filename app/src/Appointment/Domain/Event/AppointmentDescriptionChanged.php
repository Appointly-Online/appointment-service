<?php

declare(strict_types=1);

namespace App\Appointment\Domain\Event;

use App\Appointment\Domain\Model\Appointment\AppointmentId;
use App\Appointment\Domain\Model\Appointment\Description;
use Prooph\EventSourcing\AggregateChanged;

final class AppointmentDescriptionChanged extends AggregateChanged
{
    /**
     * @var Description|null
     */
    private $description;

    public function description(): Description
    {
        return Description::fromString($this->payload['description']);
    }

    public static function withData(AppointmentId $appointmentId, Description $description): self
    {
        $event = self::occur($appointmentId->toString(), [
            'description' => $description->toString()
        ]);

        $event->description = $description;

        return $event;
    }
}
