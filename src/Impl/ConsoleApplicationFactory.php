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
        return new Application();
    }
}
