<?php

/*
 * This file is part of the silpion/logger-extra-bundle package.
 *
 * (c) Julius Beckmann <beckmann@silpion.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silpion\LoggerExtraBundle\Tests;

use Silpion\LoggerExtraBundle\Logger;


/**
 * @author Julius Beckmann <beckmann@silpion.de>
 *
 * @covers Silpion\LoggerExtraBundle\Logger
 */
class LoggerTest extends \PHPUnit_Framework_TestCase
{
    /** @var  \PHPUnit_Framework_MockObject_MockObject */
    protected $requestProviderMock;

    /** @var  \PHPUnit_Framework_MockObject_MockObject */
    protected $sessionProviderMock;

    /** @var  Logger */
    protected $logger;

    protected function setUp()
    {
        $this->requestProviderMock = $this->getMockBuilder('Silpion\LoggerExtraBundle\Logger\Provider\RequestIdProvider')
          ->setMethods(array('getRequestId'))
          ->getMockForAbstractClass();

        $this->sessionProviderMock = $this->getMockBuilder('Silpion\LoggerExtraBundle\Logger\Provider\SessionIdProvider')
          ->setMethods(array('getRequestId'))
          ->getMockForAbstractClass();

        $this->logger = new Logger($this->requestProviderMock, $this->sessionProviderMock);
    }

    public function testGetRequestId()
    {
        $this->requestProviderMock->expects($this->once())->method('getRequestId')->will($this->returnValue('aRequestId'));

        $this->assertEquals('aRequestId', $this->logger->getRequestId());
    }

    public function testGetSessionId()
    {
        $this->sessionProviderMock->expects($this->once())->method('getSessionId')->will($this->returnValue('aSessionId'));

        $this->assertEquals('aSessionId', $this->logger->getSessionId());
    }
}
 