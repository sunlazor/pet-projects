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

    public function __construct(
        private readonly Connection $connection,
        private readonly string $databaseMigrationsPath,
    ) {}

    /**
     * @throws Exception
     * @throws TypesException
     * @throws \Throwable
     */
    public function execute(array $parameters = []): int
    {
        try {
            $this->connection->setAutoCommit(false);
            // 1. Создать таблицу миграций (migrations), если таблица еще не существует

            $this->checkOrCreateMigrationsTable();

            $this->connection->beginTransaction();
            // 2. Получить $appliedMigrations (миграции, которые уже есть в таблице migrations)

            $appliedMigrations = $this->getAppliedMigrations();

            // 3. Получить $migrationFiles из папки миграций

            $migrationFiles = $this->getMigrationFiles();

            // 4. Получить миграции для применения

            $migrationsToApply = array_diff($migrationFiles, $appliedMigrations);

            // 5. Создать SQL-запрос для миграций, которые еще не были выполнены

            $migrationChanges = [];
            foreach ($migrationsToApply as $migrationFile) {
                $migration = require $this->databaseMigrationsPath . $migrationFile;
                if ($migrationChange = $migration->up()) {
                    $migrationChanges[] = $migrationChange;
                }

                // 6. Добавить миграцию в базу данных
                $this->insertMigrationFact($migrationFile);
            }

            // 7. Выполнить SQL-запрос
            $schema = new Schema($migrationChanges);

            $sqlArray = $schema->toSql($this->connection->getDatabasePlatform());
             foreach ($sqlArray as $sql) {
                 $this->connection->executeQuery($sql);
             }

            $this->connection->commit();

            $this->connection->setAutoCommit(false);
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
                    ->create(),
            )
            ->addColumn(
                Column::editor()
                    ->setUnquotedName('migration')
                    ->setTypeName('string')
                    ->setLength(32)
                    ->setNotNull(true)
                    ->create(),
            )
            ->addColumn(
                Column::editor()
                    ->setUnquotedName('created_at')
                    ->setTypeName('datetime_immutable')
                    ->setDefaultValue('CURRENT_TIMESTAMP')
                    ->setNotNull(true)
                    ->create(),
            )
            ->addPrimaryKeyConstraint(
                PrimaryKeyConstraint::editor()
                    ->setUnquotedColumnNames('id')
                    ->create(),
            )
            ->create();

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
            ->fetchFirstColumn();
    }

    private function getMigrationFiles(): array
    {
        $files = [];

        $filesIterator = new \DirectoryIterator($this->databaseMigrationsPath);
        foreach ($filesIterator as $file) {
            if ($file->isFile()) {
                $files[] = $file->getFilename();
            }
        }
        return $files;
    }

    /**
     * @throws Exception
     */
    private function insertMigrationFact(string $migrationFile): void
    {
        $qb = $this->connection->createQueryBuilder();
        $qb
            ->insert(self::MIGRATIONS_TABLE_NAME)
            ->values(['migration' => ':migration'])
            ->setParameter('migration', $migrationFile)
            ->executeQuery();
    }

}