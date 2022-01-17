<?php

namespace Micro\Plugin\Console;

use Symfony\Component\Console\Command\Command;

interface ConsoleApplicationFacadeInterface
{
    /**
     * @param Command $command
     *
     * @return void
     */
    public function registerCommand(Command $command): void;

    /**
     * @return void
     *
     * @throws \Exception
     */
    public function run(): void;

    /**
     * @return bool
     */
    public function isCli(): bool;
}
