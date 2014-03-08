<?php

/*
 * This file is part of the silpion/logger-extra-bundle package.
 *
 * (c) Julius Beckmann <beckmann@silpion.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silpion\LoggerExtraBundle\EventListener;

use Silpion\LoggerExtraBundle\Logger\RequestLogger;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

/**
 * Kernel request listener.
 * Will forward incoming request to given request logger.
 *
 * @author Julius Beckmann <beckmann@silpion.de>
 */
class KernelRequestListener
{
    /** @var RequestLogger */
    private $requestLogger;

    public function __construct(RequestLogger $requestLogger)
    {
        $this->requestLogger = $requestLogger;
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        // Only handle master requests.
        if (HttpKernelInterface::MASTER_REQUEST == $event->getRequestType()) {
            $this->requestLogger->logRequest($event->getRequest());
        }
    }
}
 