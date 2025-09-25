<?php

namespace Sunlazor\BlondFramework\Event;

use Psr\EventDispatcher\StoppableEventInterface;

class AbstractEvent implements StoppableEventInterface
{
    private bool $isPropagationStopped = false;

    /**
     * @inheritDoc
     */
    public function isPropagationStopped(): bool
    {
        return $this->isPropagationStopped;
    }

    public function stopPropagation(): void
    {
        $this->isPropagationStopped = true;
    }
}