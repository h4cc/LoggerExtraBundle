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

use Silpion\LoggerExtraBundle\Logger\ResponseLogger;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

/**
 * Kernel response listener.
 * Will forward outgoing response and request to given response logger.
 *
 * @author Julius Beckmann <beckmann@silpion.de>
 */
class KernelResponseListener
{
    /** @var ResponseLogger */
    private $responseLogger;

    public function __construct(ResponseLogger $responseLogger)
    {
        $this->responseLogger = $responseLogger;
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        $this->responseLogger->logResponse($event->getResponse(), $event->getRequest());
    }
}
 