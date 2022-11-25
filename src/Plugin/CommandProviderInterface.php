<?php

namespace Micro\Plugin\Console\Plugin;

use Micro\Component\DependencyInjection\Container;
use Symfony\Component\Console\Command\Command;
use \Micro\Plugin\Console\CommandProviderInterface as DeprecatedCommandProviderInterfaceDeprecated;

interface CommandProviderInterface extends DeprecatedCommandProviderInterfaceDeprecated
{
    /**
     * @param Container $container
     * @return Command[]
     */
    public function provideConsoleCommands(Container $container): array;
}
