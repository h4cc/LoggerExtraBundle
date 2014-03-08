<?php

/*
 * This file is part of the silpion/logger-extra-bundle package.
 *
 * (c) Julius Beckmann <beckmann@silpion.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silpion\LoggerExtraBundle\Tests\EventListener;

use Silpion\LoggerExtraBundle\EventListener\KernelRequestListener;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\HttpKernelInterface;


/**
 * @author Julius Beckmann <beckmann@silpion.de>
 *
 * @covers Silpion\LoggerExtraBundle\EventListener\KernelRequestListener
 */
class KernelRequestListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testOnKernelRequestForMasterRequest()
    {
        $request = Request::create('/foo', 'POST');

        $eventMock = $this->getMockBuilder('Symfony\Component\HttpKernel\Event\GetResponseEvent')
          ->setMethods(array('getRequestType', 'getRequest'))
          ->disableOriginalConstructor()
          ->getMock();
        $eventMock->expects($this->once())->method('getRequestType')->will(
          $this->returnValue(HttpKernelInterface::MASTER_REQUEST)
        );
        $eventMock->expects($this->once())->method('getRequest')->will($this->returnValue($request));

        $loggerMock = $this->getMockBuilder('Silpion\LoggerExtraBundle\Logger\RequestLogger')
          ->setMethods(array('logRequest'))
          ->getMockForAbstractClass();
        $loggerMock->expects($this->once())->method('logRequest')->with($request);

        $listener = new KernelRequestListener($loggerMock);
        $listener->onKernelRequest($eventMock);
    }

    public function testOnKernelRequestForSubRequest()
    {
        $eventMock = $this->getMockBuilder('Symfony\Component\HttpKernel\Event\GetResponseEvent')
          ->setMethods(array('getRequestType', 'getRequest'))
          ->disableOriginalConstructor()
          ->getMock();
        $eventMock->expects($this->once())->method('getRequestType')->will(
          $this->returnValue(HttpKernelInterface::SUB_REQUEST)
        );
        $eventMock->expects($this->never())->method('getRequest');

        $loggerMock = $this->getMockBuilder('Silpion\LoggerExtraBundle\Logger\RequestLogger')
          ->setMethods(array('logRequest'))
          ->getMockForAbstractClass();
        $loggerMock->expects($this->never())->method('logRequest');

        $listener = new KernelRequestListener($loggerMock);
        $listener->onKernelRequest($eventMock);
    }
}
