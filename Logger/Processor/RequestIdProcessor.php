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

use Silpion\LoggerExtraBundle\Logger\Provider\RequestIdProvider;

/**
 * The RequestIdProcessor will add the current RequestId to each processed log message.
 *
 * @author Julius Beckmann <beckmann@silpion.de>
 */
class RequestIdProcessor
{
    private $requestIdProvider;

    public function __construct(RequestIdProvider $provider)
    {
        $this->requestIdProvider = $provider;
    }

    public function processRecord(array $record)
    {
        // Do not add if key already exists.
        if (!isset($record['extra']['request_id'])) {
            $record['extra']['request_id'] = $this->requestIdProvider->getRequestId();
        }

        return $record;
    }
}
 