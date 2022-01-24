<?php

namespace Micro\Plugin\Console;

use Micro\Component\DependencyInjection\Container;
use Symfony\Component\Console\Command\Command;

interface CommandProviderInterface
{
    /**
     * @param Container $container
     * @return Command[]
     */
    public function provideCommands(Container $container): array;
}
