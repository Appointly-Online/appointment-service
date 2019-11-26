<?php

declare(strict_types=1);

namespace App\Appointment\Application\Command\Create;

final class CreatePatientCommand
{
    /**
     * @var string
     */
    private $patientId;

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $birth;

    public function __construct(
        string $patientId,
        string $name,
        string $birth
    ) {
        $this->patientId = $patientId;
        $this->name = $name;
        $this->birth = $birth;
    }

    /**
     * @return string
     */
    public function getPatientId(): string
    {
        return $this->patientId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getBirth(): string
    {
        return $this->birth;
    }
}
