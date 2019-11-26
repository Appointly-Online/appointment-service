<?php

declare(strict_types=1);

namespace App\Appointment\Infrastructure\Persistence\ORM\Projections;

use App\Appointment\Domain\Event\PatientNameChanged;
use App\Appointment\Domain\Event\PatientWasCreated;
use Prooph\Bundle\EventStore\Projection\ReadModelProjection;
use Prooph\EventStore\Projection\ReadModelProjector;

final class PatientProjection implements ReadModelProjection
{
    public function project(ReadModelProjector $projector): ReadModelProjector
    {
        $projector->fromStreams('event_stream')
            ->when([
                PatientWasCreated::class => function ($state, PatientWasCreated $event) {
                    $readModel = $this->readModel();
                    assert($readModel instanceof PatientReadModel);
                    $readModel->stack('insert', [
                        'patient_id' => $event->patientId()->toString(),
                        'name' => $event->name()->toString(),
                        'birth' => $event->birth()->toString()
                    ]);
                },
                PatientNameChanged::class => function ($state, PatientNameChanged $event) {
                    $readModel = $this->readModel();
                    assert($readModel instanceof PatientReadModel);
                    $readModel->stack('update',
                        [
                            'name' => $event->name()->toString()
                        ],
                        [
                            'patient_id' => $event->aggregateId(),
                        ]
                    );
                }
            ]);

        return $projector;
    }
}
