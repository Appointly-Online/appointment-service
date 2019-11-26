<?php

declare(strict_types=1);

namespace App\Appointment\Infrastructure\Exception;

use RuntimeException;

class AppointmentWithSameTitleAndDescriptionFoundException extends RuntimeException
{
}