<?php

/*
 * This file is part of the silpion/logger-extra-bundle package.
 *
 * (c) Julius Beckmann <beckmann@silpion.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silpion\LoggerExtraBundle\Logger\Provider\Session;

use Silpion\LoggerExtraBundle\Logger\Provider\SessionIdProvider;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * Providing a ID based on the current session id.
 *
 * @author Julius Beckmann <beckmann@silpion.de>
 */
class SymfonySessionIdProvider implements SessionIdProvider
{
    /** @var SessionInterface */
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * Returns the session id.
     * If there is not session id yet, NULL has to be returned.
     *
     * @return string|null
     */
    public function getSessionId()
    {
        if ($this->session->isStarted()) {

            return $this->session->getId();
        }

        return null;
    }
}
 