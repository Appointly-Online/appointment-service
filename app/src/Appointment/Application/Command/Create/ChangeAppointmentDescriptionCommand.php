<?php

declare(strict_types=1);

namespace App\Appointment\Application\Command\Create;

final class ChangeAppointmentDescriptionCommand
{
    /**
     * @var string
     */
    private $appointmentId;

    /**
     * @var string
     */
    private $description;

    /**
     * ChangeAppointmentDescriptionCommand constructor.
     *
     * @param string $appointmentId
     * @param string $description
     */
    public function __construct(
        string $appointmentId,
        string $description
    ) {
        $this->appointmentId = $appointmentId;
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getAppointmentId(): string
    {
        return $this->appointmentId;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}
