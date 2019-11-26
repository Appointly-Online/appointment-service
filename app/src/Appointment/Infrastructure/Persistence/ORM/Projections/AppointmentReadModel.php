<?php

declare(strict_types=1);

namespace App\Appointment\Infrastructure\Persistence\ORM\Projections;

use Doctrine\DBAL\Connection;
use Prooph\EventStore\Projection\AbstractReadModel;

final class AppointmentReadModel extends AbstractReadModel
{
    /**
     * @var Connection
     */
    private $connection;

    /**
     * AppointmentReadModel constructor.
     *
     * @param Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    public function init(): void
    {
        $tableName = Table::APPOINTMENT;

        $sql = <<<EOT
CREATE TABLE $tableName (
  appointment_id varchar NOT NULL,
  title varchar NOT NULL,
  description varchar NOT NULL,
  PRIMARY KEY (appointment_id)
);
EOT;
        $statement = $this->connection->prepare($sql);
        $statement->execute();
    }

    public function isInitialized(): bool
    {
        $tableName = Table::APPOINTMENT;

        $sql = "SELECT * FROM pg_catalog.pg_tables WHERE tablename like '$tableName';";

        $statement = $this->connection->prepare($sql);
        $statement->execute();

        $result = $statement->fetch();

        if (false === $result) {
            return false;
        }

        return true;
    }

    public function reset(): void
    {
        $tableName = Table::APPOINTMENT;

        $sql = "TRUNCATE TABLE '$tableName';";

        $statement = $this->connection->prepare($sql);
        $statement->execute();
    }

    public function delete(): void
    {
        $tableName = Table::APPOINTMENT;

        $sql = "DROP TABLE $tableName;";

        $statement = $this->connection->prepare($sql);
        $statement->execute();
    }

    protected function insert(array $data): void
    {
        $this->connection->insert(Table::APPOINTMENT, $data);
    }

    protected function update(array $data, array $identifier): void
    {
        $this->connection->update(
            Table::APPOINTMENT,
            $data,
            $identifier
        );
    }
}