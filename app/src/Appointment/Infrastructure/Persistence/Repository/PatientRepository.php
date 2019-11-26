<?php

declare(strict_types=1);

namespace App\Appointment\Infrastructure\Persistence\Repository;

use App\Appointment\Domain\Model\Patient\Patient;
use App\Appointment\Domain\Model\Patient\PatientId;
use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Prooph\EventSourcing\Aggregate\AggregateType;
use Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator;
use Prooph\EventStore\EventStore;

class PatientRepository extends AggregateRepository implements PatientRepositoryInterface
{
    public function __construct(EventStore $eventStore)
    {
        parent::__construct(
            $eventStore,
            AggregateType::fromAggregateRootClass(Patient::class),
            new AggregateTranslator()
        );
    }

    public function save(Patient $patient): void
    {
        $this->saveAggregateRoot($patient);
    }

    public function get(PatientId $patientId): ?Patient
    {
        return $this->getAggregateRoot($patientId->toString());
    }

    public function findByCriteria(array $criteria): ?array
    {
        return [];
    }
}
