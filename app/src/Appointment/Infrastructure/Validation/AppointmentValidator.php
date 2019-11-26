<?php

declare(strict_types=1);

namespace App\Appointment\Infrastructure\Validation;

use App\Appointment\Infrastructure\Exception\AppointmentWithSameTitleAndDescriptionFoundException;
use App\Appointment\Infrastructure\Persistence\Repository\AppointmentRepositoryInterface;

final class AppointmentValidator implements AppointmentValidatorInterface
{
    /**
     * @var AppointmentRepositoryInterface
     */
    private $repository;

    public function __construct(AppointmentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string $title
     * @param string $description
     *
     * @return bool
     */
    public function appointmentWithSameTitleAndDescriptionExist(string $title, string $description): bool
    {
        if (!empty($this->repository->findByCriteria([
            'title' => $title,
            'description' => $description,
        ]))) {
            throw new AppointmentWithSameTitleAndDescriptionFoundException('We already have an appointment with the same title and description');
        }

        return false;
    }
}
