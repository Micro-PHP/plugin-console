<?php

namespace Micro\Plugin\Console;

use Micro\Component\DependencyInjection\Container;
use Micro\Component\EventEmitter\EventListenerInterface;
use Micro\Component\EventEmitter\ListenerProviderInterface;
use Micro\Framework\Kernel\Plugin\AbstractPlugin;
use Micro\Kernel\App\Business\ApplicationListenerProviderPluginInterface;
use Micro\Plugin\Console\Impl\ConsoleApplicationFacade;
use Micro\Plugin\Console\Listener\ApplicationStartEventListener;
use Micro\Plugin\Console\Listener\EventListenerProvider;

class ConsolePlugin extends AbstractPlugin implements ApplicationListenerProviderPluginInterface
{
    /**
     * @var Container
     */
    private Container $container;

    /**
     * {@inheritDoc}
     */
    public function provideDependencies(Container $container): void
    {
        $this->container = $container;

        $container->register(
            ConsoleApplicationFacadeInterface::class, function (Container $container) {
                return new ConsoleApplicationFacade($container);
            }
        );
    }

    /**
     * {@inheritDoc}
     */
    public function getEventListenerProvider(): ListenerProviderInterface
    {
        return new EventListenerProvider(
            $this->createConsoleApplicationListener()
        );
    }

    /**
     * @return EventListenerInterface
     */
    protected function createConsoleApplicationListener(): EventListenerInterface
    {
        $facade = $this->lookupConsoleApplicationFacade($this->container);

        return new ApplicationStartEventListener($facade);
    }

    /**
     * @param  Container $container
     * @return ConsoleApplicationFacadeInterface
     */
    protected function lookupConsoleApplicationFacade(Container $container): ConsoleApplicationFacadeInterface
    {
        return $container->get(ConsoleApplicationFacadeInterface::class);
    }
}
