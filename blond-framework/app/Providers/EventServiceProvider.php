<?php

namespace App\Providers;

use App\Listeners\ContentLengthListener;
use App\Listeners\EntityHandleListener;
use Psr\EventDispatcher\EventDispatcherInterface;
use Sunlazor\BlondFramework\Dbal\Event\EntityPersist;
use Sunlazor\BlondFramework\Http\Event\ResponseEvent;
use Sunlazor\BlondFramework\Providers\ServiceProviderInterface;

class EventServiceProvider implements ServiceProviderInterface
{
    private array $listeners = [
        ResponseEvent::class => [
            ContentLengthListener::class,
        ],
        EntityPersist::class => [
            EntityHandleListener::class,
        ]
    ];

    public function __construct(private EventDispatcherInterface $eventDispatcher) {}

    public function register(): void
    {
        foreach ($this->listeners as $event => $listeners) {
            foreach ($listeners as $listener) {
                $this->eventDispatcher->addListener($event, new $listener());
            }
        }
    }
}