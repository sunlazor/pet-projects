<?php

namespace Sunlazor\BlondFramework\Dbal;

use Doctrine\DBAL\Connection;
use Psr\EventDispatcher\EventDispatcherInterface;
use Sunlazor\BlondFramework\Dbal\Event\EntityPersist;

class EntityService
{
    public function __construct(private Connection $connection, private EventDispatcherInterface $eventDispatcher) {}

    public function getConnection(): Connection
    {
        return $this->connection;
    }

    public function save(AbstractEntity $entity): int
    {
        $id = $this->connection->lastInsertId();
        $entity->setId($id);

        $this->eventDispatcher->dispatch(new EntityPersist($entity));

        return $id;
    }
}