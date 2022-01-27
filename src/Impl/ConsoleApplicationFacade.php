<?php

namespace Micro\Plugin\Console\Impl;

use Micro\Component\DependencyInjection\Container;
use Micro\Plugin\Console\CommandProviderInterface;
use Micro\Plugin\Console\ConsoleApplicationFacadeInterface;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Command\Command;

class ConsoleApplicationFacade implements ConsoleApplicationFacadeInterface
{
    /**
     * @var Application|null
     */
    private ?Application $consoleApplication;

    public function __construct(private Container $container)
    {
        $this->initApplication();
    }

    /**
     * {@inheritDoc}
     */
    public function registerCommand(Command $command): void
    {
        if(!$this->consoleApplication) {
            return;
        }

        $this->consoleApplication->add($command);
    }

    /**
     * {@inheritDoc}
     */
    public function provideCommands(CommandProviderInterface $commandProvider): void
    {
        foreach ($commandProvider->provideConsoleCommands($this->container) as $command) {
            $this->registerCommand($command);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function run(): void
    {
        if(!$this->consoleApplication) {
            return;
        }

        $this->consoleApplication->run();
    }

    /**
     * @return void
     */
    private function initApplication(): void
    {
        if(!$this->isCli()) {
            $this->consoleApplication = null;

            return;
        }

        $this->consoleApplication = $this->createApplicationFactory()->create();
    }

    /**
     * @return ConsoleApplicationFactory
     */
    private function createApplicationFactory(): ConsoleApplicationFactory
    {
        return new ConsoleApplicationFactory();
    }

    /**
     * {@inheritDoc}
     */
    public function isCli(): bool
    {
        return PHP_SAPI === 'cli';
    }
}
