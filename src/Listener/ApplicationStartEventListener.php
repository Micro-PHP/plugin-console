<?php

namespace Micro\Plugin\Console\Listener;

use Micro\Component\EventEmitter\EventInterface;
use Micro\Component\EventEmitter\EventListenerInterface;
use Micro\Framework\Kernel\Plugin\ApplicationPluginInterface;
use Micro\Kernel\App\AppKernelInterface;
use Micro\Kernel\App\Business\Event\ApplicationReadyEvent;
use Micro\Plugin\Console\CommandProviderInterface;
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
     * @param ApplicationReadyEvent $event
     *
     * @throws \Exception
     */
    public function on(EventInterface $event): void
    {
        if(!$this->consoleApplication->isCli()) {
            return;
        }

        $this->registerCommands($event);

        $this->consoleApplication->run();
    }

    /**
     * @param ApplicationReadyEvent $event
     * @return void
     */
    protected function registerCommands(ApplicationReadyEvent $event): void
    {
        foreach ($event->kernel()->plugins() as $plugin) {
            $this->registerPluginCommands($plugin);
        }
    }

    /**
     * @param ApplicationPluginInterface $plugin
     * @return void
     */
    protected function registerPluginCommands(ApplicationPluginInterface $plugin): void
    {
        if(!$plugin instanceof CommandProviderInterface) {
            return;
        }

        $this->consoleApplication->provideCommands($plugin);
    }

    /**
     * {@inheritDoc}
     */
    public function supports(EventInterface $event): bool
    {
        return $event instanceof ApplicationReadyEvent;
    }
}
