<?php

declare(strict_types=1);

namespace App\Appointment\Application\Command\Create;

use App\Appointment\Domain\Model\Appointment\Appointment;
use App\Appointment\Domain\Model\Appointment\AppointmentId;
use App\Appointment\Domain\Model\Appointment\Description;
use App\Appointment\Domain\Model\Appointment\Title;
use App\Appointment\Infrastructure\Persistence\Repository\AppointmentRepositoryInterface;
use App\Appointment\Infrastructure\Validation\AppointmentValidatorInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class MakeAppointmentHandler implements MessageHandlerInterface
{
    /**
     * @var AppointmentRepositoryInterface
     */
    private $repository;

    /**
     * @var AppointmentValidatorInterface
     */
    private $validator;

    public function __construct(
        AppointmentRepositoryInterface $repository,
        AppointmentValidatorInterface $validator
    ) {
        $this->repository = $repository;
        $this->validator = $validator;
    }

    public function __invoke(MakeAppointmentCommand $command): void
    {
        $this->validator->appointmentWithSameTitleAndDescriptionExist($command->getTitle(), $command->getDescription());

        $appointment = Appointment::register(
            AppointmentId::fromString($command->getAppointmentId()),
            new Title($command->getTitle()),
            new Description($command->getDescription())
        );

        $this->repository->save($appointment);
    }
}
