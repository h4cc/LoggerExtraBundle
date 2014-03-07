<?php

/*
 * This file is part of the silpion/logger-extra-bundle package.
 *
 * (c) Julius Beckmann <beckmann@silpion.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silpion\LoggerExtraBundle\Logger\Processor;

use Silpion\LoggerExtraBundle\Logger\Provider\SessionIdProvider;

/**
 * The SessionIdProcessor will add the current session id, if available.
 *
 * @author Julius Beckmann <beckmann@silpion.de>
 */
class SessionIdProcessor
{
    private $provider;
    private $secret;

    public function __construct(SessionIdProvider $provider, $secret)
    {
        $this->provider = $provider;
        $this->secret = $secret;
    }

    public function processRecord(array $record)
    {
        // Do not add if key already exists.
        if (!isset($record['extra']['session_id'])) {
            $sessionId = $this->provider->getSessionId();

            // We assume the sessionId is sensitive data and has to be protected.
            // So we use a SHA1 checksum.
            if (!is_null($sessionId)) {
                $sessionId = sha1($this->secret . $sessionId);
            }

            $record['extra']['session_id'] = $sessionId;
        }

        return $record;
    }
}
 