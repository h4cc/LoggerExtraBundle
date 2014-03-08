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

    /**
     * @param SessionIdProvider $provider
     */
    public function __construct(SessionIdProvider $provider)
    {
        $this->provider = $provider;
    }

    public function processRecord(array $record)
    {
        // Do not add if key already exists.
        if (!isset($record['extra']['session_id'])) {
            $record['extra']['session_id'] = $this->provider->getSessionId();
        }

        return $record;
    }
}
 