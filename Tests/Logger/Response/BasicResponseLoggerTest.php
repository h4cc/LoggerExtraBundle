<?php

/*
 * This file is part of the silpion/logger-extra-bundle package.
 *
 * (c) Julius Beckmann <beckmann@silpion.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silpion\LoggerExtraBundle\Tests\Logger\Response;

use Silpion\LoggerExtraBundle\Logger\Response\BasicResponseLogger;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


/**
 * @author Julius Beckmann <beckmann@silpion.de>
 *
 * @covers Silpion\LoggerExtraBundle\Logger\Response\BasicResponseLogger
 */
class BasicResponseLoggerTest extends \PHPUnit_Framework_TestCase
{
    public function testLogRequest()
    {
        $response = new JsonResponse(array('foo' => 'bar'));
        $request = Request::create('/foo', 'POST');

        $loggerMock = $this->getMockBuilder('Psr\Log\LoggerInterface')
          ->setMethods(array('log'))
          ->getMockForAbstractClass();
        $loggerMock->expects($this->once())->method('log')->with(
          'warning',
          'Response 200 for "POST /foo"',
          array(
            'response_status_code' => 200,
            'response_charset' => null,
            'response_date' => $response->getDate(),
            'response_etag' => null,
            'response_expires' => null,
            'response_last_modified' => null,
            'response_max_age' => null,
            'response_protocol_version' => '1.0',
            'response_ttl' => null,
            'response_vary' => array(),
          )
        );

        $requestLogger = new BasicResponseLogger($loggerMock, 'warning');
        $requestLogger->logResponse($response, $request);

        $this->assertInstanceOf('Silpion\LoggerExtraBundle\Logger\ResponseLogger', $requestLogger);
    }
}
 