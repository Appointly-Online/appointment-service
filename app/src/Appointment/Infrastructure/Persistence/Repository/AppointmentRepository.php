<?php

declare(strict_types=1);

namespace App\Appointment\Infrastructure\Persistence\Repository;

use App\Appointment\Domain\Model\Appointment\Appointment;
use App\Appointment\Domain\Model\Appointment\AppointmentId;
use Prooph\EventSourcing\Aggregate\AggregateRepository;
use Prooph\EventSourcing\Aggregate\AggregateType;
use Prooph\EventSourcing\EventStoreIntegration\AggregateTranslator;
use Prooph\EventStore\EventStore;

final class AppointmentRepository extends AggregateRepository implements AppointmentRepositoryInterface
{
    public function __construct(EventStore $eventStore)
    {
        parent::__construct(
            $eventStore,
            AggregateType::fromAggregateRootClass(Appointment::class),
            new AggregateTranslator(),
        );
    }

    public function save(Appointment $appointment): void
    {
        $this->saveAggregateRoot($appointment);
    }

    public function get(AppointmentId $appointmentId): ?Appointment
    {
        return $this->getAggregateRoot($appointmentId->toString());
    }

    public function findByCriteria(array $criteria): ?array
    {
        return [];
    }
}
