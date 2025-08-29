<?php

namespace Sunlazor\BlondFramework\Console\Command;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\Column;
use Doctrine\DBAL\Schema\PrimaryKeyConstraint;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Schema\Table;
use Doctrine\DBAL\Types\Exception\TypesException;

class MigrateCommand implements CommandInterface
{
    private const string MIGRATIONS_TABLE_NAME = 'migrations';

    public static string $name = 'migrate';

    public function __construct(private readonly Connection $connection) {}

    /**
     * @throws Exception
     * @throws TypesException
     * @throws \Throwable
     */
    public function execute(array $parameters = []): int
    {
        try {
            // 1. Создать таблицу миграций (migrations), если таблица еще не существует

            $this->checkOrCreateMigrationsTable();

            $this->connection->beginTransaction();
            // 2. Получить $appliedMigrations (миграции, которые уже есть в таблице migrations)

            $appliedMigrations = $this->getAppliedMigrations();

            // 3. Получить $migrationFiles из папки миграций

            // 4. Получить миграции для применения

            // 5. Создать SQL-запрос для миграций, которые еще не были выполнены

            // 6. Добавить миграцию в базу данных

            // 7. Выполнить SQL-запрос


            $this->connection->commit();
        } catch (\Throwable $e) {
            $this->connection->rollBack();

            throw $e;
        }

        return 0;
    }

    /**
     * @throws TypesException
     * @throws Exception
     */
    private function checkOrCreateMigrationsTable(): void
    {
        $schemeManager = $this->connection->createSchemaManager();
        if ($schemeManager->tableExists(self::MIGRATIONS_TABLE_NAME)) {
            return;
        }

        $migrationTable = Table::editor()
            ->setUnquotedName(self::MIGRATIONS_TABLE_NAME)
            ->addColumn(
                Column::editor()
                    ->setUnquotedName('id')
                    ->setTypeName('integer')
                    ->setAutoincrement(true)
                    ->setUnsigned(true)
                    ->create()
            )
            ->addColumn(
                Column::editor()
                    ->setUnquotedName('migration')
                    ->setTypeName('string')
                    ->setLength(32)
                    ->setNotNull(true)
                    ->create()
            )
            ->addColumn(
                Column::editor()
                    ->setUnquotedName('created_at')
                    ->setTypeName('datetime_immutable')
                    ->setDefaultValue('CURRENT_TIMESTAMP')
                    ->setNotNull(true)
                    ->create()
            )
            ->addPrimaryKeyConstraint(
                PrimaryKeyConstraint::editor()
                    ->setUnquotedColumnNames('id')
                    ->create()
            )
            ->create()
        ;

        $schema = new Schema([$migrationTable]);

        $sqlArr = $schema->toSql($this->connection->getDatabasePlatform());

        $this->connection->executeQuery($sqlArr[0]);

        echo 'Migrations table was created' . PHP_EOL;
    }

    /**
     * @throws Exception
     */
    private function getAppliedMigrations(): array
    {
        return $this->connection
            ->createQueryBuilder()
            ->select('migration')
            ->from(self::MIGRATIONS_TABLE_NAME)
            ->fetchFirstColumn()
        ;
    }

}