<?php

/*
 * This file is part of the silpion/logger-extra-bundle package.
 *
 * (c) Julius Beckmann <beckmann@silpion.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silpion\LoggerExtraBundle\Logger\Request;

use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use Silpion\LoggerExtraBundle\Logger\RequestLogger;
use Symfony\Component\HttpFoundation\Request;

/**
 * Creating a simple log entry for each incoming request.
 *
 * @author Julius Beckmann <beckmann@silpion.de>
 */
class BasicRequestLogger implements RequestLogger
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

    public function logRequest(Request $request)
    {
        $msg = sprintf('Request "%s %s"', $request->getMethod(), $request->getRequestUri());

        $this->logger->log($this->logLevel, $msg, $this->requestToArray($request));
    }

    private function requestToArray(Request $request)
    {
        $map = array(
          'request_method' => $request->getMethod(),
          'request_uri' => $request->getRequestUri(),
          'request_host' => $request->getHost(),
          'request_port' => $request->getPort(),
          'request_scheme' => $request->getScheme(),
          'request_client_ip' => $request->getClientIp(),
          'request_content_type' => $request->getContentType(),
          'request_acceptable_content_types' => $request->getAcceptableContentTypes(),
          'request_etags' => $request->getETags(),
          'request_charsets' => $request->getCharsets(),
          'request_languages' => $request->getLanguages(),
          'request_locale' => $request->getLocale(),
          'request_auth_user' => $request->getUser(),
          'request_auth_has_password' => !is_null($request->getPassword()),
        );
        // Attributes from newer versions.
        if(method_exists($request, 'getEncodings')) {
            $map['request_encodings'] = $request->getEncodings();
        }
        if(method_exists($request, 'getClientIps')) {
            $map['request_client_ips'] = $request->getClientIps();
        }
        return $map;
    }
}
 