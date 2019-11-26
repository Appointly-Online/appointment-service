<?php

declare(strict_types=1);

namespace App\Appointment\Domain\Model\Patient;

use App\Shared\ValueObjectInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class PatientId implements ValueObjectInterface
{
    /**
     * @var UuidInterface
     */
    private $uuid;

    public static function generate(): PatientId
    {
        return new self(Uuid::uuid4());
    }

    public static function fromString(string $patientId): PatientId
    {
        return new self(Uuid::fromString($patientId));
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