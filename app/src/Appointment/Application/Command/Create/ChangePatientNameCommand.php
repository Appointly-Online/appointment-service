<?php

declare(strict_types=1);

namespace App\Appointment\Application\Command\Create;

final class ChangePatientNameCommand
{
    /**
     * @var string
     */
    private $patientId;

    /**
     * @var string
     */
    private $name;

    public function __construct(
        string $patientId,
        string $name
    ) {
        $this->patientId = $patientId;
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getPatientId(): string
    {
        return $this->patientId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
