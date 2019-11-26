<?php

declare(strict_types=1);

namespace App\Appointment\Infrastructure\Persistence\ORM\Projections;

use Doctrine\DBAL\Connection;
use Prooph\EventStore\Projection\AbstractReadModel;

final class PatientReadModel extends AbstractReadModel
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
        $tableName = Table::PATIENT;

        $sql = <<<EOT
CREATE TABLE $tableName (
  patient_id varchar NOT NULL,
  name varchar NOT NULL,
  birth varchar NOT NULL,
  PRIMARY KEY (patient_id)
);
EOT;
        $statement = $this->connection->prepare($sql);
        $statement->execute();
    }

    public function isInitialized(): bool
    {
        $tableName = Table::PATIENT;

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
        $tableName = Table::PATIENT;

        $sql = "TRUNCATE $tableName;";

        $statement = $this->connection->prepare($sql);
        $statement->execute();
    }

    public function delete(): void
    {
        $tableName = Table::PATIENT;

        $sql = "DROP TABLE $tableName;";

        $statement = $this->connection->prepare($sql);
        $statement->execute();
    }

    protected function insert(array $data): void
    {
        $this->connection->insert(Table::PATIENT, $data);
    }

    protected function update(array $data, array $identifier): void
    {
        $this->connection->update(
            Table::PATIENT,
            $data,
            $identifier
        );
    }
}