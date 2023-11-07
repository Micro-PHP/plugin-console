<?php

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Plugin\Console\Listener;

use Micro\Component\EventEmitter\EventInterface;
use Micro\Component\EventEmitter\EventListenerInterface;
use Micro\Kernel\App\Business\Event\ApplicationReadyEventInterface;
use Micro\Plugin\Console\Facade\ConsoleApplicationFacadeInterface;

class ApplicationStartEventListener implements EventListenerInterface
{
    public function __construct(
        private readonly ConsoleApplicationFacadeInterface $consoleApplicationFacade,
    ) {
    }

    /**
     * @param ApplicationReadyEventInterface $event
     *
     * @throws \Exception
     */
    public function on(EventInterface $event): void
    {
        if ('cli' !== $event->systemEnvironment() || \array_key_exists('RR_MODE', $_ENV)) {
            return;
        }

        $this->consoleApplicationFacade->run();
    }

    public static function supports(EventInterface $event): bool
    {
        return $event instanceof ApplicationReadyEventInterface;
    }
}
