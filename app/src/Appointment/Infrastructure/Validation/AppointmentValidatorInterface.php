<?php

declare(strict_types=1);

namespace App\Appointment\Infrastructure\Validation;

interface AppointmentValidatorInterface
{
    public function appointmentWithSameTitleAndDescriptionExist(string $title, string $description): bool;
}
