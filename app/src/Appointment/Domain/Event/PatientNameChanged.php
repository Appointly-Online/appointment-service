<?php

declare(strict_types=1);

namespace App\Appointment\Domain\Event;

use App\Appointment\Domain\Model\Patient\Name;
use App\Appointment\Domain\Model\Patient\PatientId;
use Prooph\EventSourcing\AggregateChanged;

final class PatientNameChanged extends AggregateChanged
{
    /**
     * @var Name|null
     */
    private $name;

    public function name(): Name
    {
        return Name::fromString($this->payload['name']);
    }

    public static function withData(PatientId $patientId, Name $name): self
    {
        $event = self::occur($patientId->toString(), [
            'name' => $name->toString()
        ]);

        $event->name = $name;

        return $event;
    }
}
