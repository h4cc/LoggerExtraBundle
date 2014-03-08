<?php

/*
 * This file is part of the silpion/logger-extra-bundle package.
 *
 * (c) Julius Beckmann <beckmann@silpion.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silpion\LoggerExtraBundle\Tests\Logger\Request;

use Silpion\LoggerExtraBundle\Logger\Request\BasicRequestLogger;
use Symfony\Component\HttpFoundation\Request;


/**
 * @author Julius Beckmann <beckmann@silpion.de>
 *
 * @covers Silpion\LoggerExtraBundle\Logger\Request\BasicRequestLogger
 */
class BasicRequestLoggerTest extends \PHPUnit_Framework_TestCase
{
    public function testLogRequest()
    {
        $request = Request::create('/foo', 'POST');

        $context = array(
          'request_method' => 'POST',
          'request_uri' => '/foo',
          'request_host' => 'localhost',
          'request_port' => 80,
          'request_scheme' => 'http',
          'request_client_ip' => '127.0.0.1',
          'request_content_type' => null,
          'request_etags' => array(),
          'request_charsets' => array('ISO-8859-1', 'utf-8', '*'),
          'request_languages' => array('en_US', 'en'),
          'request_locale' => 'en',
          'request_acceptable_content_types' => array('text/html', 'application/xhtml+xml', 'application/xml', '*/*'),
          'request_auth_user' => null,
          'request_auth_has_password' => false,
        );

        if (method_exists($request, 'getEncodings')) {
            $context['request_encodings'] = array();
        }

        if (method_exists($request, 'getClientIps')) {
            $context['request_client_ips'] = array('127.0.0.1');
        }

        $loggerMock = $this->getMockBuilder('Psr\Log\LoggerInterface')
          ->setMethods(array('log'))
          ->getMockForAbstractClass();
        $loggerMock->expects($this->once())->method('log')->with('warning', 'Request "POST /foo"', $context);


        $requestLogger = new BasicRequestLogger($loggerMock, 'warning');
        $requestLogger->logRequest($request);

        $this->assertInstanceOf('Silpion\LoggerExtraBundle\Logger\RequestLogger', $requestLogger);
    }
}
 