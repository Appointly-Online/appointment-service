<?php

declare(strict_types=1);

namespace App\Appointment\Infrastructure\Persistence\ORM\Projections;

use App\Appointment\Domain\Event\AppointmentDescriptionChanged;
use App\Appointment\Domain\Event\AppointmentWasCreated;
use Prooph\Bundle\EventStore\Projection\ReadModelProjection;
use Prooph\EventStore\Projection\ReadModelProjector;

final class AppointmentProjection implements ReadModelProjection
{
    public function project(ReadModelProjector $projector): ReadModelProjector
    {
        $projector->fromStreams('event_stream')
            ->when([
                AppointmentWasCreated::class => function ($state, AppointmentWasCreated $event) {
                    /** @var AppointmentReadModel $readModel */
                    $readModel = $this->readModel();
                    $readModel->stack('insert', [
                        'appointment_id' => $event->aggregateId(),
                        'title' => $event->title()->toString(),
                        'description' => $event->description()->toString()
                    ]);
                },
                AppointmentDescriptionChanged::class => function ($state, AppointmentDescriptionChanged $event) {
                    /** @var AppointmentReadModel $readModel */
                    $readModel = $this->readModel();
                    $readModel->stack('update',
                        [
                            'description' => $event->description()->toString()
                        ],
                        [
                            'appointment_id' => $event->aggregateId(),
                        ]
                    );
                }
            ]);

        return $projector;
    }
}