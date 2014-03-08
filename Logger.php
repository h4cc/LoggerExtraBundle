<?php

/*
 * This file is part of the silpion/logger-extra-bundle package.
 *
 * (c) Julius Beckmann <beckmann@silpion.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silpion\LoggerExtraBundle;

use Silpion\LoggerExtraBundle\Logger\Provider\RequestIdProvider;
use Silpion\LoggerExtraBundle\Logger\Provider\SessionIdProvider;
use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Public facade of this bundle.
 *
 * @author Julius Beckmann <beckmann@silpion.de>
 */
class Logger extends Bundle
{
    /**
     * @var Logger\Provider\RequestIdProvider
     */
    private $requestIdProvider;

    /**
     * @var Logger\Provider\SessionIdProvider
     */
    private $sessionIdProvider;

    public function __construct(RequestIdProvider $requestIdProvider, SessionIdProvider $sessionIdProvider)
    {
        $this->requestIdProvider = $requestIdProvider;
        $this->sessionIdProvider = $sessionIdProvider;
    }

    /**
     * Returns the provided request id.
     *
     * @return string
     */
    public function getRequestId()
    {
        return $this->requestIdProvider->getRequestId();
    }

    /**
     * Returns the provided session id.
     *
     * @return null|string
     */
    public function getSessionId()
    {
        return $this->sessionIdProvider->getSessionId();
    }
}
