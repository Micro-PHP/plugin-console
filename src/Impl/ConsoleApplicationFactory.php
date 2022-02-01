<?php

namespace Micro\Plugin\Console\Impl;

use Symfony\Component\Console\Application;

class ConsoleApplicationFactory
{
    /**
     * @return Application
     */
    public function create(): Application
    {
        $application =  new Application();
        $application->setAutoExit(false);
        //$application->setCatchExceptions(true);

        return $application;
    }
}
