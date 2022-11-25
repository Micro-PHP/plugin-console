<?php

namespace Micro\Plugin\Console\Listener;

use Micro\Component\DependencyInjection\Autowire\AutowireHelperInterface;
use Micro\Component\EventEmitter\EventInterface;
use Micro\Component\EventEmitter\EventListenerInterface;
use Micro\Kernel\App\Business\Event\ApplicationReadyEvent;
use Micro\Plugin\Console\ConsoleApplicationFacadeInterface;
use Micro\Plugin\Locator\Facade\LocatorFacadeInterface;
use Symfony\Component\Console\Command\Command;

class ApplicationStartEventListener implements EventListenerInterface
{
    /**
     * @param LocatorFacadeInterface $locatorFacade
     * @param ConsoleApplicationFacadeInterface $consoleApplication
     * @param AutowireHelperInterface $autowireHelper
     */
    public function __construct(
        private readonly LocatorFacadeInterface $locatorFacade,
        private readonly ConsoleApplicationFacadeInterface $consoleApplication,
        private readonly AutowireHelperInterface $autowireHelper
    )
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
        foreach ($this->locatorFacade->lookup(Command::class) as $command) {
            $cmdCallback = $this->autowireHelper->autowire($command);
            $this->consoleApplication->registerCommand($cmdCallback());
        }
    }

    /**
     * {@inheritDoc}
     */
    public static function supports(EventInterface $event): bool
    {
        return $event instanceof ApplicationReadyEvent;
    }
}
