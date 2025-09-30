<?php

namespace Sunlazor\BlondFramework\Dbal\Event;

use Sunlazor\BlondFramework\Dbal\AbstractEntity;
use Sunlazor\BlondFramework\Event\AbstractEvent;

class EntityPersist extends AbstractEvent
{
    public function __construct(private AbstractEntity $entity) {}

    public function getEntity(): AbstractEntity
    {
        return $this->entity;
    }
}