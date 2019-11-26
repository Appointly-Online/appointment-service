<?php

declare(strict_types=1);

namespace App\Appointment\Domain\Exception;

use Exception;

class SameDescriptionException extends Exception
{
    protected $message = 'Changed Description was the same';
}
