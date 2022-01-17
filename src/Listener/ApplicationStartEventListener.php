<?php

namespace Micro\Plugin\Console\Listener;

use Micro\Component\EventEmitter\EventInterface;
use Micro\Component\EventEmitter\EventListenerInterface;
use Micro\Kernel\App\Business\Event\ApplicationReadyEvent;
use Micro\Plugin\Console\ConsoleApplicationFacadeInterface;

class ApplicationStartEventListener implements EventListenerInterface
{
    /**
     * @param ConsoleApplicationFacadeInterface $consoleApplication
     */
    public function __construct(private ConsoleApplicationFacadeInterface $consoleApplication)
    {
    }

    /**
     * {@inheritDoc}
     *
     * @throws \Exception
     */
    public function on(EventInterface $event): void
    {
        if(!$this->consoleApplication->isCli()) {
            return;
        }

        $this->consoleApplication->run();
    }

    /**
     * {@inheritDoc}
     */
    public function supports(EventInterface $event): bool
    {
        return $event instanceof ApplicationReadyEvent;
    }
}
