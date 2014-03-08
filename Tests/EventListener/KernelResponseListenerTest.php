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

use Silpion\LoggerExtraBundle\EventListener\KernelResponseListener;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Julius Beckmann <beckmann@silpion.de>
 *
 * @covers Silpion\LoggerExtraBundle\EventListener\KernelResponseListener
 */
class KernelResponseListenerTest extends \PHPUnit_Framework_TestCase
{
    public function testOnKernelRequestForMasterRequest()
    {
        $request = Request::create('/foo', 'POST');
        $response = new JsonResponse(array('foo' => 'bar'));

        $eventMock = $this->getMockBuilder('Symfony\Component\HttpKernel\Event\FilterResponseEvent')
          ->setMethods(array('getResponse', 'getRequest'))
          ->disableOriginalConstructor()
          ->getMock();
        $eventMock->expects($this->once())->method('getResponse')->will($this->returnValue($response));
        $eventMock->expects($this->once())->method('getRequest')->will($this->returnValue($request));

        $loggerMock = $this->getMockBuilder('Silpion\LoggerExtraBundle\Logger\ResponseLogger')
          ->setMethods(array('logResponse'))
          ->getMockForAbstractClass();
        $loggerMock->expects($this->once())->method('logResponse')->with($response, $request);

        $listener = new KernelResponseListener($loggerMock);
        $listener->onKernelResponse($eventMock);
    }
}
