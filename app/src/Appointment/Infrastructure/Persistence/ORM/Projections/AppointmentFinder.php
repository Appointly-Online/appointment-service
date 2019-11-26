<?php

declare(strict_types=1);

namespace App\Appointment\Infrastructure\Persistence\ORM\Projections;

use Doctrine\DBAL\Connection;
use PDO;
use function sprintf;

class AppointmentFinder
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * AppointmentFinder constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->connection->setFetchMode(PDO::FETCH_OBJ);
    }

    public function findAll(): array
    {
        return $this->connection->fetchAll(sprintf('SELECT * FROM %s', Table::APPOINTMENT));
    }
}
