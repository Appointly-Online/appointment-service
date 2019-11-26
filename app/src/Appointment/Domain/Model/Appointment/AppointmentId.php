<?php

declare(strict_types=1);

namespace App\Appointment\Domain\Model\Appointment;

use App\Shared\ValueObjectInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class AppointmentId implements ValueObjectInterface
{
    /**
     * @var UuidInterface
     */
    private $uuid;

    public static function generate(): AppointmentId
    {
        return new self(Uuid::uuid4());
    }

    public static function fromString(string $appointmentId): AppointmentId
    {
        return new self(Uuid::fromString($appointmentId));
    }

    private function __construct(UuidInterface $uuid)
    {
        $this->uuid = $uuid;
    }

    public function toString(): string
    {
        return $this->uuid->toString();
    }

    public function sameValueAs(ValueObjectInterface $other): bool
    {
        return \get_class($this) === \get_class($other) && $this->uuid->equals($other->uuid);
    }
}