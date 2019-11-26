<?php

declare(strict_types=1);

namespace App\Appointment\Infrastructure\Persistence\Repository;

use App\Appointment\Domain\Model\Patient\Patient;
use App\Appointment\Domain\Model\Patient\PatientId;

interface PatientRepositoryInterface
{
    public function save(Patient $appointment): void;

    public function get(PatientId $patientId): ?Patient;

    public function findByCriteria(array $criteria): ?array;
}
