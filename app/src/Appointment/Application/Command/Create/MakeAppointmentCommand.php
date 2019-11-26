<?php

declare(strict_types=1);

namespace App\Appointment\Application\Command\Create;

final class MakeAppointmentCommand
{
    /**
     * @var string
     */
    private $appointmentId;

    /**
     * @var string
     */
    private $title;
    /**
     * @var string
     */
    private $description;

    public function __construct(
        string $appointmentId,
        string $title,
        string $description
    ) {
        $this->appointmentId = $appointmentId;
        $this->title = $title;
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
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}
