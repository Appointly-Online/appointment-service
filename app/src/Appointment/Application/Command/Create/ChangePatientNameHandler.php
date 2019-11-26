<?php

declare(strict_types=1);

namespace App\Appointment\Application\Command\Create;

use App\Appointment\Domain\Model\Patient\Birth;
use App\Appointment\Domain\Model\Patient\Name;
use App\Appointment\Domain\Model\Patient\Patient;
use App\Appointment\Domain\Model\Patient\PatientId;
use App\Appointment\Infrastructure\Persistence\Repository\PatientRepositoryInterface;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class ChangePatientNameHandler implements MessageHandlerInterface
{
    /**
     * @var PatientRepositoryInterface
     */
    private $repository;

    public function __construct(
        PatientRepositoryInterface $repository
    ) {
        $this->repository = $repository;
    }

    public function __invoke(ChangePatientNameCommand $command): void
    {
        $patient = $this->repository->get(PatientId::fromString($command->getPatientId()));
        $patient->changeName(
            new Name($command->getName()),
        );

        $this->repository->save($patient);
    }
}
