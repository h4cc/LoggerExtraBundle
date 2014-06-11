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

    /** @var  string */
    private $secret;

    /** @var  bool */
    private $startSession;

    public function __construct(SessionInterface $session, $secret, $startSession=false)
    {
        $this->session = $session;
        $this->secret = $secret;
        $this->startSession = $startSession;
    }

    /**
     * Returns the session id.
     * If there is not session id yet, NULL has to be returned.
     *
     * @return string|null
     */
    public function getSessionId()
    {
        if($this->startSession && !$this->session->isStarted()) {
            $this->session->start();
        }

        if ($this->session->isStarted()) {
            // We assume the sessionId contains data and has to be protected,
            // so we use a salted SHA1 checksum.
            return sha1($this->secret . $this->session->getId());
            // In the end this method will be called for _each_ log message.
            // If the session id would be constant and accessible through the whole request,
            // this would not be necessary.
        }

        return null;
    }
}
 