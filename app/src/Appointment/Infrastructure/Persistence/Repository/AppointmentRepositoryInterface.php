<?php

declare(strict_types=1);

namespace App\Appointment\Infrastructure\Persistence\Repository;

use App\Appointment\Domain\Model\Appointment\Appointment;
use App\Appointment\Domain\Model\Appointment\AppointmentId;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

interface AppointmentRepositoryInterface
{
    public function save(Appointment $appointment): void;

    public function get(AppointmentId $appointmentId): ?Appointment;

    public function findByCriteria(array $criteria): ?array;
}