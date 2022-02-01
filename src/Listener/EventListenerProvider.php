<?php

namespace Micro\Plugin\Console\Listener;

use Micro\Component\EventEmitter\EventListenerInterface;
use Micro\Component\EventEmitter\Impl\Provider\AbstractListenerProvider;

class EventListenerProvider extends AbstractListenerProvider
{
    /**
     * @param EventListenerInterface $applicationStartListener
     */
    public function __construct(private EventListenerInterface $applicationStartListener)
    {
    }

    /**
     * {@inheritDoc}
     */
    public function getEventListeners(): iterable
    {
        return [
            $this->applicationStartListener
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function getName(): string
    {
        return 'console';
    }
}
