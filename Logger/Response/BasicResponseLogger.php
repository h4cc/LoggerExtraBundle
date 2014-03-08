<?php

/*
 * This file is part of the silpion/logger-extra-bundle package.
 *
 * (c) Julius Beckmann <beckmann@silpion.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silpion\LoggerExtraBundle\Logger\Response;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Silpion\LoggerExtraBundle\Logger\ResponseLogger;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Creating a simple log entry for each outgoing response.
 *
 * @author Julius Beckmann <beckmann@silpion.de>
 */
class BasicResponseLogger implements ResponseLogger
{
    /** @var \Psr\Log\LoggerInterface */
    private $logger;
    /**
     * @var
     */
    private $logLevel;

    public function __construct(LoggerInterface $logger, $logLevel = LogLevel::INFO)
    {
        $this->logger = $logger;
        $this->logLevel = $logLevel;
    }

    public function logResponse(Response $response, Request $request)
    {
        $msg = sprintf(
          'Response %s for "%s %s"',
          $response->getStatusCode(),
          $request->getMethod(),
          $request->getRequestUri()
        );

        $this->logger->log($this->logLevel, $msg, $this->responseToArray($response));
    }

    private function responseToArray(Response $response)
    {
        return array(
          'response_status_code' => $response->getStatusCode(),
          'response_charset' => $response->getCharset(),
          'response_date' => $response->getDate(),
          'response_etag' => $response->getEtag(),
          'response_expires' => $response->getExpires(),
          'response_last_modified' => $response->getLastModified(),
          'response_max_age' => $response->getMaxAge(),
          'response_protocol_version' => $response->getProtocolVersion(),
          'response_ttl' => $response->getTtl(),
          'response_vary' => $response->getVary(),
        );
    }
}
 