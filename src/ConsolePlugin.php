<?php

namespace Micro\Plugin\Console;

use Micro\Component\DependencyInjection\Container;
use Micro\Framework\Kernel\Plugin\AbstractPlugin;
use Micro\Plugin\Console\Impl\ConsoleApplicationFacade;

class ConsolePlugin extends AbstractPlugin
{
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
}
