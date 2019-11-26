<?php

declare(strict_types=1);

namespace App\Appointment\Application\Command\Create;

use App\Appointment\Domain\Model\Appointment\Appointment;
use App\Appointment\Domain\Model\Appointment\AppointmentId;
use App\Appointment\Domain\Model\Appointment\Description;
use App\Appointment\Infrastructure\Persistence\Repository\AppointmentRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class ChangeAppointmentDescriptionHandler implements MessageHandlerInterface
{
    /**
     * @var AppointmentRepositoryInterface
     */
    private $repository;

    public function __construct(
        AppointmentRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function __invoke(ChangeAppointmentDescriptionCommand $command): void
    {
        $appointment = $this->repository->get(AppointmentId::fromString($command->getAppointmentId()));
        assert($appointment instanceof Appointment);
        $appointment->changeDescription(Description::fromString($command->getDescription()));

        $this->repository->save($appointment);
    }
}
