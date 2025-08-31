<?php

namespace Sunlazor\BlondFramework\Dbal;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Tools\DsnParser;

class ConnectionFactory
{
    public function __construct(
        private readonly string $databaseUrl,
    ) {}

    /**
     * @throws Exception
     */
    public function create(): Connection
    {
        $connectionParams = new DsnParser()->parse($this->databaseUrl);
        $conn = DriverManager::getConnection($connectionParams);
        $conn->setAutoCommit(false);

        return $conn;
    }
}