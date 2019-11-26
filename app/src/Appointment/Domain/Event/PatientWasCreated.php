<?php

declare(strict_types=1);

namespace App\Appointment\Domain\Event;

use App\Appointment\Domain\Model\Patient\Birth;
use App\Appointment\Domain\Model\Patient\Name;
use App\Appointment\Domain\Model\Patient\PatientId;
use Prooph\EventSourcing\AggregateChanged;

final class PatientWasCreated extends AggregateChanged
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

    public function patientId(): PatientId
    {
        if (null === $this->patientId) {
            $this->patientId = PatientId::fromString($this->aggregateId());
        }

        return $this->patientId;
    }

    public function name(): Name
    {
        return Name::fromString($this->payload['name']);
    }

    public function birth(): Birth
    {
        return Birth::fromString($this->payload['birth']);
    }

    public static function withData(PatientId $patientId, Name $name, Birth $birth): self
    {
        $event = self::occur($patientId->toString(), [
            'name' => $name->toString(),
            'birth' => $birth->toString()
        ]);

        $event->name = $name;
        $event->birth = $birth;

        return $event;
    }
}
