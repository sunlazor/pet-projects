<?php

namespace App\Listeners;

use Sunlazor\BlondFramework\Dbal\Event\EntityPersist;

class EntityHandleListener {
    public function __invoke(EntityPersist $event): void
    {
//        dd($event->getEntity());
    }
}